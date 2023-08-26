<?php

namespace App\Repositories\Account;

use App\Exceptions\CoreException;
use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class AccountRepository implements AccountRepositoryInterface
{

    public function __construct(
        private Account $account
    ){}

    /**
     * Список всех счетов.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->account
                    ->with(['currency', 'bank'])
                    ->get();
    }

    /**
     * Список всех аккаунтов определенного пользователя.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAccountByUser(int $userId) : Collection
    {
        return $this->account
            ->where('user_id', $userId)
            ->with(['currency', 'card', 'wallet'])
            ->get();
    }

    /**
     * Найти счет по идентификатору,
     *
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findAccount(string $id) : Model
    {
        $model = $this->account
            ->where('id', $id)
            ->with(['currency', 'bank'])
            ->first();
        if(!$model) { throw new CoreException(Lang::get('account.not_found')); }
        // Если запись есть возвращаем ее
        return $model;
    }

    /**
     * Добавить новый счет в базу данных.
     *
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createAccount(array $input) : Model
    {
        $model = $this->account->newModelInstance();
        // Заполняем модель
        $model->fill($input);
        $model->save();

        $model = $model->refresh();
        return $model;
    }

    /**
     * Списать деньги со счета плательщика.
     *
     * @param string $accountPayer
     * @param float $amount
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function chargeMoney($accountPayer, $amount) : Model
    {
        // Списываем средства
        $this->findAccount($accountPayer)
            ->decrement('balance', $amount);
        // Возвращаем обновленную модель
        return $this->findAccount($accountPayer);
    }

    /**
     * Зачислить деньги на счет плательщика.
     *
     * @param string $accountPayer
     * @param float $amount
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function creditMoney($accountPayee, $amount) : Model
    {
        // Списываем средства
        $this->findAccount($accountPayee)
            ->increment('balance', $amount);
        // Возвращаем обновленную модель
        return $this->findAccount($accountPayee);
    }

    /**
     * Список всех счетов определенного пользователя.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAccountsByUser(int $userId) : Collection
    {
        return $this->account
            ->where('user_id', $userId)
            ->get();
    }

    /**
     * Удалить счет по ID.
     *
     * @param string $id
     * @return bool
     */
    public function removeAccountById(string $id) : bool
    {
        // Проверяем существует ли запись
        return $this->findAccount($id)->delete();
    }

}
