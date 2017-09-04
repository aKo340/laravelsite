<?php

namespace Lar;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    public function users() {
        return $this->belongsToMany('Lar\User','role_user');
    }

    public function perms() {
        return $this->belongsToMany('Lar\Permission','permission_role');
    }

}
