<?php

namespace App\Repository;
use App\Models\User;
use App\Models\Post;
use App\Models\Channel;

class UserRepository {
  protected $user;

  public function __construct(User $user) {
    $this->user = $user;
  }
  public function getAllChannels($page = 1) {
    $userId = $this->user->id; // 본인이 아닌 대상유저
    $joins = Channel::whereHas('channelJoins', function($q) use ($userId) {
        $q->where('user_id', $userId);
    })
        ->get();
    $channels = Channel::where('user_id', $userId)
        ->with('channelJoins')
        ->get();
    $values = $joins->merge($channels)->sortBy('updated_at', SORT_REGULAR, true)->forPage($page, 10);

    return $values;
}
public function findUser($id) {
  return $this->user->find($id);
}
public function getPosts($el) {
  $userId = $this->user->id;

  if($el == "post") {
    $posts = Post::where('user_id', $userId)
    ->with('user')
    ->with('likes')
    ->withCount('comments')
    ->orderby("id", "desc")
    ->get();
    
  } else if($el == "comment") {
    $posts = Post::join('comments', 'posts.id', '=', 'comments.post_id')
    ->where('comments.user_id', $userId)
    ->with('user')
    ->with('likes')
    ->withCount('comments')
    ->orderby("id", "desc")
    ->get();
    
  } else if($el == "scrap") {
    $posts = Post::join('scraps', function($q) {
      $q->on('posts.id', '=', 'scraps.post_id');
      $q->where('scraps.deleted_at', null);
    })
    ->with('channel')
    ->with('likes')
    ->with('user')
    ->withCount('comments')
    ->where('scraps.user_id', $userId)
    ->orderby("scraps.created_at", "desc")
    ->get();
    
  } else if($el == "channel") {
    $this->getAllChannels();
    // $this->userRepository->getAllChannels();
    // $posts = $user->allChannels();
  }
    return $posts;
}
}