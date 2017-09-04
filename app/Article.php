<?php

namespace Lar;

use Illuminate\Database\Eloquent\Model;

class Article extends Model

{
    //

    protected $fillable = ['title','img','alias','text','desc','keywords','meta_desc','category_id'];

    public function user() {
        return $this->belongsTo('Lar\User');
    }

    public function category() {
        return $this->belongsTo('Lar\Category');
    }

    public function comments()
    {
        return $this->hasMany('Lar\Comment');
    }

}
