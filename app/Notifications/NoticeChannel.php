<?php

namespace App\Notifications;
use Illuminate\Notifications\Notification;

class NoticeChannel
{
    public function send($notifiable, Notification $notification)
    {
        $checkOwner = $notification->checkOwner($notifiable); // 글쓴이와 댓글쓴이가 동일한지
        if($checkOwner) { // 동일하다면 종료
            return false;
        }
        $postID = $notification->getPostID();
        $result = $notifiable->notifications()->where('data->postID', $postID)->whereNull('read_at')->first();

        if($result) {
            $count = $result->data['count'];
            $data = $notification->toModifyNoticeNotification($count);
            $notifiable->notifications()->where('data->postID', $postID)->updaㅠte($data);
        } else {
            $data = $notification->toNoticeNotification($notifiable);

            return $notifiable->routeNotificationFor('database')->create([
                'id' => $notification->id,
                'type' => get_class($notification),
                'data' => $data,
            ]);
        }
    }
}
