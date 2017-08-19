<?php

namespace Lar\Repositories;


use Lar\Comment;

class CommentsRepository extends Repository {

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

}