<?php

namespace Lar\Repositories;


use Lar\Slider;

class SlidersRepository extends Repository {

    public function __construct(Slider $slider)
    {
        $this->model = $slider;
    }

}