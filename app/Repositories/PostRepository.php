<?php

namespace App\Repositories;
use App\Models\Post;
use Illuminate\Contracts\Support\ValidatedData;

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
    public function findByChannelId(int $channelId)
    {
        return $this->model->where('channel_id', $channelId)->get();
    }
    public function getPostById(int $id)
    {
        return $this->model->findOrFail($id);
    }
    public function save(array $validatedData)
    {
        return $this->model->create($validatedData);
    }
}