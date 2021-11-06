<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class Noticenotification extends Notification
{
    use Queueable;
    protected $comment;
    private $postID; // post
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
        $this->postID = $this->comment->postID;
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
            'post_id' => $this->postID,
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
        return $this->postID;
    }
    public function getPostTitle() {
        return $this->title;
    }
    public function checkOwner($notifiable) {
        $postOwnerID = $this->comment->post->userID;
        if($postOwnerID == $this->comment->userID) {
            return true;
        } else {
            return false;
        }
    }
}
