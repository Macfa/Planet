<?php

namespace App\Services\Front;

use App\Repositories\ChannelVisitHistoryRepository;
use App\Repositories\ChannelRepository;
use App\Repositories\PostRepository;

class HomeService
{
    protected $postRepository;
    protected $channelRepository;
    protected $channelVisitHistoryRepository;

    public function __construct(PostRepository $postRepository, ChannelRepository $channelRepository, ChannelVisitHistoryRepository $channelVisitHistoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->channelRepository = $channelRepository;
        $this->channelVisitHistoryRepository = $channelVisitHistoryRepository;
    }
    public function getHomeData(): array
    {
        $posts = $this->postRepository->getAll();
        $channels = $this->channelRepository->getAll();
        $channelVisitHistories = $this->channelVisitHistoryRepository->recent();

        return compact('posts', 'channels', 'channelVisitHistories');
    }
}