<?php

namespace App\Services;
use App\Models\User;
use App\Repository\UserRepository;
use App\Models\Post;
use App\Models\ChannelVisitHistory;

class UserService {  
  protected $userRepository;
  
  public function __construct(UserRepository $userRepository) {
    $this->userRepository = $userRepository;
  }
  
  public function getData($user, $el) {
    $posts = $this->userRepository->getPosts($el);
    // $user = $this->userRepository->findUser($user->id);
    $channelVisitHistories = ChannelVisitHistory::showHistory();
    
    $coin = array();
    $coin['totalCoin'] = $user->hasCoins()->sum('coin');
    $coin['postCoin'] = $user->hasCoins()->where('coinable_type', 'App\Models\Post')->sum('coin');
    $coin['commentCoin'] = $user->hasCoins()->where('coinable_type', 'App\Models\Comment')->sum('coin');
    $coin['postCount'] = $user->hasCoins()->where('coinable_type', 'App\Models\Post')->count();
    $coin['commentCount'] = $user->hasCoins()->where('coinable_type', 'App\Models\Comment')->count();
    
    $coin = (object)$coin;

    $result = [ $posts, $channelVisitHistories, $coin ];
    return $result;
  }
}