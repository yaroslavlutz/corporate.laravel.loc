<?php
namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /** Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
    */
    public function handle($request, Closure $next) {
        //dd($locale);
        $raw_locale = Session::get('locale');     # Если пользователь уже был на нашем сайте, то в сессии будет значение выбранного им языка.
        if (in_array($raw_locale, Config::get('app.locales'))) { //Проверяем, что у пользователя в сессии установлен доступный для приложения язык, а не что-то другое
            $locale = $raw_locale; //Присваиваем зн-е из сессии  переменной $locale.
        }
        else $locale = Config::get('app.locale'); //В ином случае для безопасности и предотвращения сбоев и ошибок присваиваем ей язык по умолчанию

        App::setLocale($locale); //Устанавливаем локаль приложения
        return $next($request); //И позволяем приложению работать дальше
    }

} //__/SetLocale
