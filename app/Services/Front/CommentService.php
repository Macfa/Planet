<?php

namespace App\Services\Front;

use App\Repositories\CommentRepository;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
    public function getCommentsByPostId(int $post_id)
    {
        return $this->commentRepository->getByPostId($post_id);
    }
}
