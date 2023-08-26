<?php

namespace App\Services;

use App\Exceptions\CoreException;
use App\Exports\UserExport;
use App\Imports\UserImport;
use App\Repositories\Connection\ConnectionRepository;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        // Диск по умолчанию
        private string $disk = "s3"
    ){}

     /**
     * Получить список всех подключений
     * (пользователей проекта).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        // Подключаем репозиторий
        $connectionRepository = app(ConnectionRepository::class);
        // Менеджеры получают только информацию о пользователях
        // подключенных к проекту, в связи с чем, для
        // получения списка всех пользователей используем
        // модель «Connection» с отношением User
        return $connectionRepository->all();
    }

    /**
     * Получить объект данных пользователя по ID.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getUser(int $userId) : Model
    {
        return $this->userRepository->findUser($userId);
    }

    /**
     * Найти пользователя по адресу электронной почты.
     *
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUserByEmail(string $email) : Model|null
    {
        return $this->userRepository->findUserByEmail($email);
    }

    /**
     * Получить объект данных авторизированного пользователя.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getMe() : Model
    {
        // Проверяем статус авторизации
        if(!Auth::check()){
            throw new CoreException(Lang::get('user.not_authorized'));
        }
        // Возвращаем информацию о пользователе
        return $this->getUser(Auth::user()->id);
    }

     /**
     * Обновить данные пользователя в системе.
     *
     * @param int $userId
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateUser(int $userId,
                               Request $request) : Model
    {
        $input = $request->only([
            'name', 'email', 'surname', 'patronymic', 'address'
        ]);
        // Обновляем данные пользователя
        $user = $this->userRepository->updateUser($userId, $input);
        // Возвращаем данные пользователя
        return $user;
    }

    /**
     * Получить идентификатор текущего пользователя
     *
     * @return int
     */
    public function getUserId() : int
    {
        // Возвращаем ID
        return $this->getMe()->id;
    }

    /**
     * Изменить пароль авторизированного пользователя.
     *
     * @param string $oldPassword
     * @param string $newPassword
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function changePassword(string $oldPassword, string $newPassword) : Model
    {
        // Получаем данные аутентифицированного пользователя
        $user = $this->getMe();
        // ID авторизированного пользователя
        $userId = $user->id;
        // Проверяем статус авторизации
        if(!Hash::check($oldPassword, $user->password)){
            throw new CoreException(Lang::get('user.password_corrupted'));
        }
        // Устанавливаем Новый пароль
        $input = ['password' => Hash::make($newPassword)];
        // Обновляем даныне
        $user = $this->userRepository->updateUser($userId, $input);
        // Возвращаем обновленную модель
        return $user;
    }

    /**
     * Аутентифицировать пользователя
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function loginUser(Request $request) : array
    {
        // Формируем полученный массив аутентификационных данных
        $input = $request->only(['email', 'password']);
        // Производим попытку аутентификации пользователя
        $auth = Auth::attempt($input);
        // Проверяем данные аутентификации
        if(!$auth){
            throw new CoreException(Lang::get('user.invalid_credential'));
        }
        // Формируем токен
        $user = $this->userRepository->findUser(Auth::user()->id);
        $token = $user->createToken('authToken')->accessToken;
        // Возвращаем данные
        return ['user' => Auth::user(), 'access_token' => $token];
    }

    /**
     * Зарегистрировать нового пользователя,
     * и аутентифицировать его в системе.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function registerUser(Request $request) : array
    {
        // Формирование массива данных
        $input = [
            'email' => $request->email,
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(10),
        ];
        // Регистрируем нового пользователя
        $user = $this->createUser($input);
        // Аутентифицируем пользователя
        $token = $user->createToken('authToken')->accessToken;
        // Возвращаем данные
        return ['user' => Auth::user(), 'access_token' => $token];
    }

    /**
     * Зарегистрировать нового пользователя,
     * и аутентифицировать его в системе.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createUser(array $input) : Model
    {
        // Регистрируем нового пользователя
        $user = $this->userRepository->createUser($input);
        $user->assignRole('client');
        return $user;
    }

    /**
     * Прекратить пользовательскую сессию
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function logoutUser(Request $request) : void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

}
