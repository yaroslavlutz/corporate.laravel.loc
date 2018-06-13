<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /** Where to redirect users after login.
     * @var string
    */ /* if '/' - то после Логинации/Разлогинации редиректим на нашу Гл.стр.`HOME`; if '/admin' то попадаем в нашу Админку для которой у нас и есть URL '/admin' */
    protected $redirectTo = '/'; //изначально(стандартно) тут было '/home' и после логинации редиректилось на URL '/home'

    /** Create a new controller instance.
     * @return void
    */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }


    /** Redirect the user to the GitHub authentication page.
     * @param $provider - name of provider API ('google', 'facebook', 'twitter', 'github')
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
        /* Для отключения проверки состояния сесии может использоваться метод без сохранения состояния. Это полезно при добавлении социальной аутентификации в API:
            return Socialite::driver('google')->stateless()->user();
        */
    }

    /** Obtain the user information from GitHub.
     * @param $provider - name of provider API ('google', 'facebook', 'twitter', 'github')
     * @return \Illuminate\Http\Response
    */
    public function handleProviderCallback($provider) {
        $socialiteUser = Socialite::driver($provider)->user();
        //dump($socialiteUser); //смотреть данные Юзера,кот.пришли с API Google/FaceBook,тогда далее можем с ними что-то делать

        switch( $provider ) {
            case "google":
                /*
                echo $user->getId(); echo '<br/>';
                echo $user->getNickname(); echo '<br/>';
                echo $user->getName(); echo '<br/>';
                echo $user->getEmail(); echo '<br/>';
                echo '<img src="'.$user->getAvatar().'">';
                */
                $data = [
                    'name' => $socialiteUser->getName(),
                    'email' => $socialiteUser->getEmail(),
                    'provider' => 'google',
                    'provider_id'=> $socialiteUser->getId(),
                    'password'=> 'google',
                ];
                //проверяем есть ли в нашей БД(таб.`users`) уже такой Юзер с таким же ID в $socialiteUser->getId()
                $user = User::where( 'provider', '=', 'google' )->where( 'provider_id', '=', $socialiteUser->getId() )->get();
                if( count($user) == 0 ) { //если такого Юзера нет,то сохраняем его там
                    $user = new User( $data );
                    $user->save();
                }
                else { //если такой Юзер уже есть,то просто получаем его Объект для последующей автологинации
                    $user = $user[0];
                }
                break;

            case "facebook":
                /*
                echo $user->getId(); echo '<br/>';
                echo $user->getNickname(); echo '<br/>';
                echo $user->getName(); echo '<br/>';
                echo $user->getEmail(); echo '<br/>';
                echo '<img src="'.$user->getAvatar().'">';
                */
                $data = [
                    'name' => $socialiteUser->getName(),
                    'email' => $socialiteUser->getEmail(),
                    'provider' => 'facebook',
                    'provider_id'=> $socialiteUser->getId(),
                    'password'=> 'facebook',
                ];
                //проверяем есть ли в нашей БД(таб.`users`) уже такой Юзер с таким же ID в $socialiteUser->getId()
                $user = User::where( 'provider', '=', 'facebook' )->where( 'provider_id', '=', $socialiteUser->getId() )->get();
                if( count($user) == 0 ) { //если такого Юзера нет,то сохраняем его там
                    $user = new User( $data );
                    $user->save();
                }
                else { //если такой Юзер уже есть,то просто получаем его Объект для последующей автологинации
                    $user = $user[0];
                }
                break;
            default:
                echo "Error!!!";
        }
        Auth::login($user); //автологинация Юзера
        return redirect('/login');
        //$user->token;
    }

}
