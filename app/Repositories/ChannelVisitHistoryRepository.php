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
    public function recent()
    {
        return $this->model->get();
    }
    public function count()
    {
        return $this->model->count();
    }
    public function upsertVisits(array $data)
    {
        return $this->model->upsert($data, ['user_id', 'channel_id'], ['updated_at']);
    }
    public function deleteOverLimit()
    {
        return $this->model->where('user_id', auth()->id())->orderBy('updated_at')->skip(5)->delete();
    }
}