<?php

namespace Lar\Repositories;


use Config;

abstract class Repository {

    protected $model = FALSE;


    public function get($select = '*',$take = FALSE,$pagination = FALSE, $where = FALSE) {

        $builder = $this->model->select($select);

        if($take) {
            $builder->take($take);
        }

        if ($where) {
            $builder->where($where[0], $where[1]);
        }


        if($pagination) {
            return $this->check($builder->paginate(Config::get('settings.paginate')));
        }

        return $this->check($builder->get());
    }

    protected function check($result) {

        if($result->isEmpty()) {
            return FALSE;
        }

        $result->transform(function($item,$key) {

            if(is_string($item->img) && is_object(json_decode($item->img)) && (json_last_error() == JSON_ERROR_NONE)) {
                $item->img = json_decode($item->img);
            }

            return $item;

        });

        return $result;

    }

    public function one($alias, $attr = array()) {
        $result = $this->model->where('alias', $alias)->first();

        return $result;
    }

    public function transliterate($string) {
        $str = mb_strtolower($string, 'UTF-8');

        $leter_array = array(
            'a' => 'а,ā',
			'b' => 'b',
			'v' => 'v',
			'g' => 'g,ģ',
			'd' => 'd',
			'e' => 'е,ē',
			'zh' => 'ž',
			'z' => 'z',
			'i' => 'i,ī',
			'j' => 'j',
			'k' => 'k,ķ',
			'l' => 'l,ļ',
			'm' => 'm',
			'n' => 'n,ņ',
			'o' => 'o',
			'p' => 'p',
			'r' => 'r',
			's' => 's',
			'sh' => 'š',
			't' => 't',
			'u' => 'u,ū',
			'f' => 'f',
        );

        foreach ($leter_array as $let => $lat) {
            $lat = explode(',',$lat);

            $str = str_replace($lat, $let, $str);

        }

        $str = preg_replace('/(\s|[^A-Za-z0-9\-])+/','-',$str);

        $str = trim($str,'-');

        return $str;

    }

}