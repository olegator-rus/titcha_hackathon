<?php

namespace App\Repositories\Wallet;

use App\Exceptions\CoreException;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class WalletRepository implements WalletRepositoryInterface
{

    public function __construct(
        private Wallet $wallet
    ){}

    /**
     * Список всех кошельков.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->wallet
                    ->with(['account'])
                    ->get();
    }

    /**
     * Список всех кошельков определенного пользователя.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWalletsByUser(int $userId) : Collection
    {
        return $this->wallet
            ->where('user_id', $userId)
            ->with(['account'])
            ->get();
    }

    /**
     * Найти кошелек по идентификатору,
     *
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findWallet(string $id) : Model
    {
        $model = $this->wallet
            ->where('id', $id)
            ->with(['account'])
            ->first();
        if(!$model) { throw new CoreException(Lang::get('wallet.not_found')); }
        // Если запись есть возвращаем ее
        return $model;
    }

    /**
     * Добавить новый кошелек в базу данных.
     *
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createWallet(array $input) : Model
    {
        $model = $this->wallet->newModelInstance();
        // Заполняем модель
        $model->fill($input);
        $model->save();

        $model = $model->refresh();
        return $model;
    }

    /**
     * Обновить данные определенного кошелька.
     *
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateWallet(string $id, array $input) : Model
    {
        $model = $this->findWallet($id);
        $model->fill($input);
        $model->save();

        $model = $model->refresh();
        return $model;
    }

    /**
     * Удалить кошелек по ID.
     *
     * @param string $id
     * @return bool
     */
    public function removeWalletById(string $id) : bool
    {
        // Проверяем существует ли запись
        return $this->findWallet($id)->delete();
    }

}
