<?php

namespace Lar;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['name','text','site','user_id','article_id','parent_id','email'];

    public function article() {
        return $this->belongsTo('Lar\Article');
    }

    public function user() {
        return $this->belongsTo('Lar\User');
    }
}
