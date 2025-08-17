<?php

namespace App\Repositories;
use App\Models\Post;

class PostRepository extends BaseRepository
{
    protected $model;

    public function __construct(Post $post)
    {
        $this->model = $post;
    }
    public function getAll()
    {
        return $this->model->all();
    }
}