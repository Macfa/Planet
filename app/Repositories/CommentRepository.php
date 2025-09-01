<?php

namespace App\Repositories;
use App\Models\Comment;
use Illuminate\Contracts\Support\ValidatedData;

class CommentRepository extends BaseRepository
{
    protected $model;

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }
    public function getAll()
    {
        return $this->model->all();
    }
    public function getByPostId(int $post_id)
    {
        return $this->model->where('post_id', $post_id)->get();
    }
}