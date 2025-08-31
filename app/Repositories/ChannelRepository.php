<?php
namespace App\Repositories;

use App\Models\Channel;

class ChannelRepository extends BaseRepository
{
    protected $model;

    public function __construct(Channel $channel)
    {
        $this->model = $channel;
    }
    public function getAll()
    {
        return $this->model->get();
    }
    public function create(Array $data)
    {
        return $this->model->create($data);
    }
    public function with($relations)
    {
        return $this->model->with($relations);
    }
    public function getAllByUserId(int $user_id)
    {
        return $this->model->where('user_id', $user_id)->get();
    }
    // public function findById($id)
    // {
    //     return $this->model->find($id);
    // }
}