<?php

namespace Lar\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Lar\Http\Controllers\Controller;
use Menu;

use Auth;



use Lar\User;

class AdminController extends \Lar\Http\Controllers\Controller
{
    //
    protected $p_rep;
    protected $a_rep;
    protected $user;
    protected $template;
    protected $content = FALSE;
    protected $title;
    protected $vars;


    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
//dd($this->user);
            if(!$this->user) {
                abort(403);
            }

            return $next($request);
        });


    }


    public function renderOutput() {
    $this->vars = array_add($this->vars,'title',$this->title);

        $menu = $this->getMenu();

        $navigation = view(env('THEME').'.admin.navigation')->with('menu',$menu)->render();
        $this->vars = array_add($this->vars,'navigation',$navigation);

        if($this->content) {
            $this->vars = array_add($this->vars,'content',$this->content);
        }

        $footer = view(env('THEME').'.admin.footer')->render();
        $this->vars = array_add($this->vars,'footer',$footer);

        return view($this->template)->with($this->vars);


    }



        public function getMenu() {
            return Menu::make('adminMenu', function($menu) {

                $menu->add('Raksti',array('route' => 'articles.index'));

                $menu->add('Portfolio',  array('route' => 'articles.index'));
                $menu->add('Menu',  array('route' => 'articles.index'));
                $menu->add('Lietotāji',  array('route' => 'articles.index'));
                $menu->add('Privilēģijas',  array('route' => 'articles.index'));


            });
        }

}
