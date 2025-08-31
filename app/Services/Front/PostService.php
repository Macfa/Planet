<?php

namespace App\Services\Front;
use App\Repositories\ChannelRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;

class PostService
{
    protected $channelRepository;
    protected $postRepository;

    public function __construct(ChannelRepository $channelRepository, PostRepository $postRepository)
    {
        $this->channelRepository = $channelRepository;
        $this->postRepository = $postRepository;
    }
    public function createPost(Array $validated)
    {
        // 네이밍 규칙이 좀 애매...
        try {
            $this->postRepository->save($validated);
        }
    }
}
