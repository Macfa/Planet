<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class Noticenotification extends Notification
{
    use Queueable;
    protected $comment;
    private $post_id; // post
    private $title; // post
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->title = $this->comment->post->title;
        $this->post_id = $this->comment->post_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [NoticeChannel::class];
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
    public function toNoticeNotification($notifiable)
    {
//        dd($notifiable);
        return [
            'post_id' => $this->post_id,
            'msg' => "'".$this->title."' 게시글에 댓글이 달렸습니다",
            'count' => 1
        ];
    }
    public function toModifyNoticeNotification($originCount)
    {
        $tobeCount = $originCount+1;

        return [
            'data->msg' => "'".$this->title."' 게시글에 ".$tobeCount."개의 댓글이 달렸습니다",
            'data->count' => $tobeCount
        ];
    }
    public function getPostID() {
        return $this->post_id;
    }
    public function getPostTitle() {
        return $this->title;
    }
    public function checkOwner($notifiable) {
        $postOwnerID = $this->comment->post->user_id;
        if($postOwnerID == $this->comment->user_id) {
            return true;
        } else {
            return false;
        }
    }
}
