<?php

namespace Lar;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    //
    public function filter() {
        return $this->belongsTo('Lar\Filter','filter_alias','alias');
    }
}
