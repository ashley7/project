<?php

namespace App\Notifications;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegisteredSuccessfully extends Notification
{
    
  /**
  * @var User
  */
 protected $user;
 /**
  * Create a new notification instance.
  *
  * @param User $user
  */
 public function __construct(User $user)
 {
     $this->user = $user;
 }
 /**
  * Get the notification's delivery channels.
  *
  * @param  mixed  $notifiable
  * @return array
  */
 public function via($notifiable)
 {
     return ['mail'];
 }
 /**
  * Get the mail representation of the notification.
  *
  * @param  mixed  $notifiable
  * @return \Illuminate\Notifications\Messages\MailMessage
  */
 public function toMail($notifiable)
 {
     /** @var User $user */
     $user = $this->user;
     return (new MailMessage)
         ->from(env('MAIL_USERNAME'))
         ->subject('ICWEA Portal, Account Verification')
         ->greeting(sprintf('Hello %s', $user->surname))
         ->line('Your account has been verified successfully')
         ->action('Click Here', url('/'))
         ->line('Hope you will enjoy this service.');
 }
 
 /**
  * Get the array representation of the notification.
  *
  * @param  mixed  $notifiable
  * @return array
  */
 public function toArray($notifiable)
 {
     return [
         //
     ];
 }
}
