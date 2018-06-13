<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;
    //__________________________________________________________________________________________________________________
    protected $test_variable_for_mail = 'Text of test for e-mail template.. ++'; //просто тестовая переменная для наглядности и тестирования
    protected $mail_subject = 'A new subject E-mail'; //Тема для письма
    protected $mail_date; //Дата для письма
    protected $path_to_attache_file; //путь к файлу который присоединяем к письму

    protected $name_user;  //В это св-во будет попадать Имя Юзера,кот.он внес в Форму отправки
    protected $email_user; //В это св-во будет попадать E-Mail Юзера,кот.он внес в Форму отправки
    protected $comment_user;  //В это св-во будет попадать Коммент(сообщение) Юзера,кот.он внес в Форму отправки
    //__________________________________________________________________________________________________________________

    /** Create a new message instance.
     * @param $name_user
     * @param $email_user
     * @param $comment_user
    */ /*В Конструкторе переопределяем в соответствующие одноименные св-ва Класса,те данные из Контроллера `app/Http/Controllers/ContactResourceController.php` кот.нам нужны и кот.мы будем передавать в шаблон письма */
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

        /* Можно указать адрес "from" прям тут,в Классе mailable, как сейчас,а можно глобально, если такой адрес "from" будет единым для всего приложения.
            Если Приложение использует один и тот же адрес "from" во всех своих письмах,можно указать глобальный адрес "from" в конфиге config/mail.php (см.`config/mail.php` и настройку 'from' => [..] )
            Этот адрес будет использоваться,если больше не указан ни один адрес "from" в классе mailable
        */
        return $this->from($this->email_user)->view('frontendsite.'.env('THEME').'.emailtemplate') //'frontendsite.emailtemplate' - шаблон для письма-это View,которую нужно создать и в ней сделать этот шаблон для письма
        ->with([
            'name_user' => $this->name_user,  //передаем в шаблон письма данные: Имя Юзера,кот.он внес в Форму отправки
            'email_user' => $this->email_user, //передаем в шаблон письма данные: E-Mail Юзера,кот.он внес в Форму отправки
            'comment_user' => $this->comment_user,  //передаем в шаблон письма данные: коммент(сообщение) Юзера,кот.он внес в Форму отправки
            'mail_date' => $this->mail_date,  //передаем в шаблон письма данные: дата для письма,чтобы указать дату и время отправки письма
            'test_variable_for_mail' => $this->test_variable_for_mail  //просто тестовая переменная которую передаем в шаблон для примера и тестирования
        ])
            ->subject($this->mail_subject) //Тема для письма
            ->attach( $this->path_to_attache_file, [ 'as' => 'my_image_file.png', 'mime' => 'application/png' ] ); //`attach()` - метод для присоед.файла к письму. 1-й арг.- путь к файлу; 2-й арг.- какое имя хотим ему переприсвоить; 3-й арг.- тип файла
    }

} //__/class OrderShipped
