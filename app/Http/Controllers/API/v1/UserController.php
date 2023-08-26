<?php

namespace App\Http\Controllers\API\v1;

use App\Services\UserService;
use App\Traits\JsonResponds;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{

    // Подключаем трейт ответов
    use JsonResponds;

    /**
     * Получить список всех пользователей,
     * подключенных к мероприятию.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\UserService $userService
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request,
                        UserService $userService) : Response
    {
        try
        {
            $users = $userService->all();

            return $this->success(
                Lang::get('user.all'),
                $users
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Найти определенного пользователя по ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\UserService $userService
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request,
                        UserService $userService) : Response
    {
        try
        {
            // Получаем идентификатор пользователя
            $userId = (int) $request->id;
            $users = $userService->getUser($userId);

            return $this->success(
                Lang::get('user.get'),
                $users
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Обновить данные пользователя.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\UserService $userService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,
                           UserService $userService) : Response
    {
        DB::beginTransaction();
        try
        {

            // Определяем ID пользователя для обновления
            $userId = (int) $request->id;
            // Обновляем данные
            $user = $userService->updateUser($userId, $request);
            // Завершаем транзакцию
            DB::commit();
            // Возвращаем статус и данные
            return $this->success(
                Lang::get('user.update'),
                $user
            );

        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Получить информацию о пользователе.
     *
     * @param \App\Services\UserService $userService
     * @return \Illuminate\Http\Response
     */
    public function me(UserService $userService) : Response
    {
        try
        {
            $user = $userService->getMe();

            return $this->success(
                Lang::get('user.me'),
                $user
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Экспортировать данные определенной группы защит.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\UserService $userService
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request,
                           UserService $userService) : Response
    {
        DB::beginTransaction();
        try
        {
            // Определяем ID пользователя для обновления
            $fileId = (string) $request->file_id;
            // Получаем ссылку на таблицу пользователей
            $userService->importUserTable($fileId);
            // Завершаем транзакцию
            DB::commit();
            return $this->success(
                Lang::get('user.imported')
            );
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Экспортировать данные определенной группы защит.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\UserService $userService
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request,
                           UserService $userService) : Response
    {
        DB::beginTransaction();
        try
        {
            // Получаем ссылку на таблицу пользователей
            $url = $userService->exportUserTable();
            // Завершаем транзакцию
            DB::commit();
            return $this->success(
                Lang::get('user.exported'),
                $url
            );
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }
}
