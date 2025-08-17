<?php

namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use App\Services\Front\ChannelService;

class ChannelController extends Controller
{
    protected $channelService;

    public function __construct(ChannelService $channelService)
    {
        $this->channelService = $channelService;
    }
    public function create()
    {

    }
    public function update()
    {

    }
    public function delete(Int $id)
    {
        $result = $this->channelService->delete($id);
        return $result;
    }
}