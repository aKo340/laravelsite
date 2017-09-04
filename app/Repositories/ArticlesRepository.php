<?php

namespace Lar\Repositories;


use Image;
use Lar\Article;

class ArticlesRepository extends Repository {


    public function __construct(Article $articles) {
        $this->model = $articles;
    }

    public function one($alias, $attr = array())
    {
        $article = parent::one($alias, $attr);

        if ($article && !empty($attr)) {
            $article->load('comments');
            $article->comments->load('user');
        }

        return $article;

    }

    public function addArticle($request) {
        if (\Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image');

        if (empty($data)) {
            return array('error' => 'Nav datu');
        }

        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        if ($this->one($data['alias'],FALSE)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => 'Dotais pseidonīms jau tiek izmantots'];

        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $str = str_random(8);

                $obj = new \stdClass();

                $obj->mini = $str.'_mini.jpg';
                $obj->max = $str.'_max.jpg';
                $obj->path = $str.'.jpg';

                $img = Image::make($image);

                $img->fit(\Config::get('settings.image')['width'],
                            \Config::get('settings.image')['height'])
                    ->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->path);

                $img->fit(\Config::get('settings.articles_img')['max']['width'],
                    \Config::get('settings.articles_img')['max']['height'])
                    ->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->max);

                $img->fit(\Config::get('settings.articles_img')['mini']['width'],
                    \Config::get('settings.articles_img')['mini']['height'])
                    ->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->mini);

                $data['img'] = json_encode($obj);

                $this->model->fill($data);

                if ($request->user()->articles()->save($this->model)) {
                    return ['status' => 'Raksts pievienots'];
                }

            }
        }

    }

}