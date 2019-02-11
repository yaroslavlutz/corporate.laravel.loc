<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    protected $test_variable_for_mail = 'Text of test for e-mail template.. ++'; 
    protected $mail_subject = 'A new subject E-mail';
    protected $mail_date;
    protected $path_to_attache_file; 

    protected $name_user;
    protected $email_user; 
    protected $comment_user;

    public function __construct( $name_user, $email_user, $comment_user ) {
        $this->name_user = $name_user;
        $this->email_user = $email_user;
        $this->comment_user = $comment_user;
    }

    /** Build the message.
     * @return $this
    */
    public function build() {
        $this->mail_date = date("F j, Y, g:i a");
        $this->path_to_attache_file = public_path('img/mailtrap_settings_account.png');

        return $this->from($this->email_user)->view('frontendsite.'.env('THEME').'.emailtemplate') 
        ->with([
            'name_user' => $this->name_user,
            'email_user' => $this->email_user,
            'comment_user' => $this->comment_user, 
            'mail_date' => $this->mail_date,
            'test_variable_for_mail' => $this->test_variable_for_mail
        ])
            ->subject($this->mail_subject)
            ->attach( $this->path_to_attache_file, [ 'as' => 'my_image_file.png', 'mime' => 'application/png' ] ); 
    }
}
