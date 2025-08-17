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
        return $this->model->all();
    }
}