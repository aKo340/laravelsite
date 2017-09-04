<?php

namespace Lar\Http\Controllers\Admin;

use Illuminate\Http\Request;

//use Lar\Http\Requests;

use Lar\Http\Controllers\Controller;

use Gate;


class IndexController extends AdminController
{
    //
    public function __construct() {

        parent::__construct();
//dd(Gate::denies(\Auth::user()));

//        if (Gate::denies('VIEW_ADMIN')) {
//            abort(404);
//        }

        $this->template = env('THEME').'.admin.index';

    }

    public function index() {
        $this->title = 'Administratora panelis';

        return $this->renderOutput();

    }

}
