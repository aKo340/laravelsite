<?php

namespace Lar\Http\Controllers\Admin;

use Illuminate\Http\Request;


use Lar\Http\Controllers\Controller;
use Lar\Http\Requests\ArticleRequest;
use Lar\Http\Requests;
use Lar\Repositories\ArticlesRepository;
use Gate;

use Lar\Article;
use Lar\Category;


class ArticlesController extends AdminController
{

    public function __construct(ArticlesRepository $a_rep) {
//dd(Gate::denies(\Auth::user()));

//        if (Gate::denies('VIEW_ADMIN_ARTICLES')) {
//            abort(404);
//        }

        $this->a_rep = $a_rep;

        $this->template = env('THEME').'.admin.articles';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->title = 'Rakstu menedžeris';

        $articles = $this->getArticles();
        $this->content = view(env('THEME').'.admin.articles_content')->with('articles',$articles)->render();


        return $this->renderOutput();

    }

    public function getArticles() {
        return $this->a_rep->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Gate::denies('save', new \Lar\Article)) {
            abort(403);
        }

        $this->title = "Pievienot jaunu rakstu";

        $categories = Category::select(['title', 'alias', 'parent_id','id'])->get();

        $lists = array();

        foreach ($categories as $category) {
            if ($category->parent_id == 0) {
                $lists[$category->title] = array();
            }
            else {
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        $this->content = view(env('THEME').'.admin.articles_create_content')->with('categories', $lists)->render();

        return $this->renderOutput();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        //
            $result = $this->a_rep->addArticle($request);

            if (is_array($result) && !empty(['error'])) {
                return back()->with($result);
            }

            return redirect('/admin')->with($result);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($alias) {

        $article = Article::where('alias', $alias);

        if (Gate::denies('edit', new Article)) {
            abort(403);
        }
//        dd($article);

        $article->img = json_decode($article->img);

        $categories = Category::select(['title', 'alias', 'parent_id','id'])->get();

        $lists = array();

        foreach ($categories as $category) {
            if ($category->parent_id == 0) {
                $lists[$category->title] = array();
            }
            else {
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        $this->title = 'Raksta - '. $article->title.' labošana';

        $this->content = view(env('THEME').'.admin.articles_create_content')->with(['categories' => $lists, 'article' => $article])->render();

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
