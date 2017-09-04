<?php

namespace Lar;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    public function roles() {
        return $this->belongsToMany('Lar\Role','permission_role');
    }

}
