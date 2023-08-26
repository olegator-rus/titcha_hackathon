<?php

namespace App\Http\Controllers\API\v1;

use App\Services\UserService;
use App\Traits\JsonResponds;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

class AuthController extends Controller
{
    // Подключаем трейт ответов
    use JsonResponds;

    /**
     * Получить авторизациооный токен.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\UserService $userService
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request,
                          UserService $userService) : Response
    {
        try
        {
            // Формируем данные доступа
            $session = $userService->loginUser($request);

            // Производим авторизацию
            return $this->success(
                Lang::get('auth.logged_in'),
                $session
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Прекратить пользовательскую сессию.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\UserService $userService
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request,
                           UserService $userService) : Response
    {
        try
        {
            $session = $userService->logoutUser($request);

            return $this->success(
                Lang::get('auth.logged_out'),
                $session
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }
}
