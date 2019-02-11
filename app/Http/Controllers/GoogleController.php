<?php
namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /** Redirect the user to the GitHub authentication page.
     * @return \Illuminate\Http\Response
    */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /** Obtain the user information from GitHub.
     * @return \Illuminate\Http\Response
    */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        /* All Providers */
        echo $user->getId(); echo '<br/>';
        echo $user->getNickname(); echo '<br/>';
        echo $user->getName(); echo '<br/>';
        echo $user->getEmail(); echo '<br/>';

        echo '<img src="'.$user->getAvatar().'">';
    }

}
