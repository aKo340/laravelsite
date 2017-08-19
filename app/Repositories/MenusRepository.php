<?php

namespace Lar\Repositories;


use Lar\Menu;

class MenusRepository extends Repository {

    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

}