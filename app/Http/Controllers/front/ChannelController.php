<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeChannelReqeust;
use App\Services\Front\ChannelService;
use App\Services\Front\ChannelVisitHistoryService;
use Illuminate\Support\Facades\Request;

class ChannelController extends Controller
{
    protected $channelService;
    protected $channelVisitHistoryService;

    public function __construct(ChannelService $channelService, ChannelVisitHistoryService $channelVisitHistoryService)
    {
        $this->channelService = $channelService;
        $this->channelVisitHistoryService = $channelVisitHistoryService;
    }
    public function show(Int $id)
    {
        // $id 대신 $request ?
        $channelCompactValue = $this->channelService->getChannelWithPosts($id);
        $this->channelVisitHistoryService->createChannelVisitHistories([
            'user_id' => auth()->id(),
            'channel_id' => $id
        ]);
        return view('channel.show', $channelCompactValue);
    }
    public function create()
    {
        return view('channel.create');
    }
    public function store(storeChannelReqeust $request)
    {
        // validation
        $validated = $request->validated();
        $last_data = [
            ...$validated,
            'user_id' => auth()->user()->id
        ];
        $created_channel = $this->channelService->createChannel($last_data);
        return redirect('/channel/' . $created_channel->id);
    }
    public function edit()
    {

    }
    public function update()
    {

    }
    public function destory(Int $id)
    {
        $result = $this->channelService->delete($id);
        return $result;
    }
}