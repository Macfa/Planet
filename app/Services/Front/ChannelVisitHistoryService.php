<?php

namespace App\Services\Front;

use App\Models\Channel;
use App\Repositories\ChannelVisitHistoryRepository;

class ChannelVisitHistoryService
{
    protected $repository;

    public function __construct(ChannelVisitHistoryRepository $channelVisitHistoryRepository)
    {
        // Constructor code here
        $this->repository = $channelVisitHistoryRepository;
    }
    public function recent()
    {
        // 날짜 내림차순으로 데이터 가져오기
        return $this->repository->recent();
    }
    public function createChannelVisitHistories(array $data)
    {
        // 채널 조회 시, 이력 생성 로직 호출
        // 만약 기존에 있는 이력이라면 날짜 갱신
        // 없다면 이력 생성 
        // 순번대로 5개 이후부터는 삭제
        $this->repository->upsertVisits($data);
        if($this->repository->count() > 5) {
            $this->repository->deleteOverLimit();
        }
    }
    // public function count()
    // {
    //     // 존재할 필요 없어보임
    //     // Method to count total channel visit histories
    // }
}