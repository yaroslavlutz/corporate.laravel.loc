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
    */
    protected $redirectTo = '/'; 

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
    }

    /** Obtain the user information from GitHub.
     * @param $provider - name of provider API ('google', 'facebook', 'twitter', 'github')
     * @return \Illuminate\Http\Response
    */
    public function handleProviderCallback($provider) {
        $socialiteUser = Socialite::driver($provider)->user();
        switch( $provider ) {
            case "google":
                $data = [
                    'name' => $socialiteUser->getName(),
                    'email' => $socialiteUser->getEmail(),
                    'provider' => 'google',
                    'provider_id'=> $socialiteUser->getId(),
                    'password'=> 'google',
                ];

                $user = User::where( 'provider', '=', 'google' )->where( 'provider_id', '=', $socialiteUser->getId() )->get();
                if( count($user) == 0 ) { 
                    $user = new User( $data );
                    $user->save();
                }
                else { 
                    $user = $user[0];
                }
                break;

            case "facebook":
                $data = [
                    'name' => $socialiteUser->getName(),
                    'email' => $socialiteUser->getEmail(),
                    'provider' => 'facebook',
                    'provider_id'=> $socialiteUser->getId(),
                    'password'=> 'facebook',
                ];
                $user = User::where( 'provider', '=', 'facebook' )->where( 'provider_id', '=', $socialiteUser->getId() )->get();
                if( count($user) == 0 ) { 
                    $user = new User( $data );
                    $user->save();
                }
                else {
                    $user = $user[0];
                }
                break;
            default:
                echo "Error!!!";
        }
        Auth::login($user); 
        return redirect('/login');
    }
}
