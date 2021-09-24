<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class Noticenotification extends Notification
{
    use Queueable;
    private $comment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
//    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->checkExistNoti($notifiable);
    }

    public function checkExistNoti($notifiable) {
        $postID = $this->comment->postID;

        $result = $notifiable->notifications()->where('data->postID', $postID)->first('data');
        $count = $result['count'] ?? 1;
//        dd($result->data['msg'], $result->data, $count);
        $msg = $this->getMessage($postID, $count);
        return $msg;
    }

    public function getMessage($postID, $count) {
        $postName = $this->comment->post->title;
//        dd($this);
        if($count==0) {
            // 기존에 알림이 존재한다면
            return [
                'postID' => $postID,
                'msg' => $postName. " 게시글에 ".$count."개의 댓글이 달렸습니다.",
                'count' => $count
            ];
        } else {
            // 신규 알림이라면
            return [
                'postID' => $postID,
                'msg' => $postName." 게시글에 댓글이 달렸습니다",
                'count' => 1
            ];
        }
    }
}
