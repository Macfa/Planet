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
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public function getPosts()
    {
        try {
            $posts = $this->postRepository->getAll();
            return $posts;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public function getPost($id)
    {
        try {
            $post = $this->postRepository->getPostById($id);
            // return compact('post');
            return $post;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
