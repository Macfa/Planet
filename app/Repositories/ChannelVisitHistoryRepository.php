<?php
namespace App\Repositories;

use App\Models\ChannelVisitHistory;

class ChannelVisitHistoryRepository extends BaseRepository
{
    protected $model;

    public function __construct(ChannelVisitHistory $channelVisitHistory)
    {
        $this->model = $channelVisitHistory;
    }
    public function getAll()
    {
        return $this->model->all();
    }
}