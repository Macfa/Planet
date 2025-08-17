<?php

namespace App\Services\Front;
use App\Repositories\ChannelRepository;

class ChannelService
{
    protected $channelRepository;

    public function __construct(ChannelRepository $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }
    public function create()
    {
        
    }
    public function update()
    {

    }
    public function delete()
    {

    }
}