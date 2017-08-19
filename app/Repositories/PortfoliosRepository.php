<?php

namespace Lar\Repositories;

use Lar\Portfolio;

class PortfoliosRepository extends Repository
{
    public function __construct(Portfolio $portfolio) {
        $this->model = $portfolio;
    }

}