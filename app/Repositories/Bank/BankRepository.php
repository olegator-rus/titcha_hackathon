<?php

namespace App\Repositories\Bank;

use App\Exceptions\CoreException;
use App\Models\Bank;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class BankRepository implements BankRepositoryInterface
{

    public function __construct(
        private Bank $bank
    ){}

    /**
     * Список всех банков.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->bank->get();
    }

    /**
     * Найти банк по идентификатору,
     *
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findBank(string $id) : Model
    {
        $model = $this->bank
            ->where('id', $id)
            ->first();
        if(!$model) { throw new CoreException(Lang::get('bank.not_found')); }
        // Если запись есть возвращаем ее
        return $model;
    }

    /**
     * Найти центральный банк по идентификатору валюты,
     *
     * @param string $currencyId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findCentralBank(string $currencyId) : Model
    {
        $model = $this->bank
            ->where('currency_id', $currencyId)
            ->where('is_central', true)
            ->first();
        if(!$model) { throw new CoreException(Lang::get('bank.not_found')); }
        // Если запись есть возвращаем ее
        return $model;
    }


    /**
     * Добавить новый банк в базу данных.
     *
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createBank(array $input) : Model
    {
        $model = $this->bank->newModelInstance();
        // Заполняем модель
        $model->fill($input);
        $model->save();

        $model = $model->refresh();
        return $model;
    }

    /**
     * Обновить данные определенного эмитента.
     *
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateBank(string $id, array $input) : Model
    {
        $model = $this->findBank($id);
        $model->fill($input);
        $model->save();

        $model = $model->refresh();
        return $model;
    }

    /**
     * Удалить банк по ID.
     *
     * @param string $id
     * @return bool
     */
    public function removeBankById(string $id) : bool
    {
        // Проверяем существует ли запись
        return $this->findBank($id)->delete();
    }

}
