<?php

namespace App\Services\Front;
use App\Repositories\ChannelRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;

class ChannelService
{
    protected $channelRepository;
    protected $postRepository;

    public function __construct(ChannelRepository $channelRepository, PostRepository $postRepository)
    {
        $this->channelRepository = $channelRepository;
        $this->postRepository = $postRepository;
    }
    public function getAll()
    {
        return $this->channelRepository->getAll();
    }
    public function getAllForUser(int $user_id)
    {
        return $this->channelRepository->getAllByUserId($user_id);
    }
    public function getChannelWithPosts(int $id)
    {
        // return $this->channelRepository->with('posts')->find($id);
        $channel = $this->channelRepository->findById($id);
        $posts = $this->postRepository->findByChannelId($id);

        return compact('channel', 'posts');
    }   
    public function getChannel(int $id)
    {
        return $this->channelRepository->findById($id);
    }
    public function createChannel(Array $validated)
    {
        return $this->channelRepository->create($validated);
    }
    public function update()
    {

    }
    public function delete(int $id)
    {
        // $this->channelRepository->delete($id);
    }
}
