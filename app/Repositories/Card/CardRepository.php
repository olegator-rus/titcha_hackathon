<?php

namespace App\Repositories\Card;

use App\Exceptions\CoreException;
use App\Models\Card;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class CardRepository implements CardRepositoryInterface
{

    public function __construct(
        private Card $card
    ){}

    /**
     * Список всех карт.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->card
            ->with(['account'])
            ->get();
    }

    /**
     * Список всех карт определенного пользователя.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCardsByUser(int $userId) : Collection
    {
        return $this->card
            ->where('user_id', $userId)
            ->get();
    }

    /**
     * Найти карту по идентификатору,
     *
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findCard(string $id) : Model
    {
        $model = $this->card
            ->where('id', $id)
            ->with(['account'])
            ->first();
        if(!$model) { throw new CoreException(Lang::get('card.not_found')); }
        // Если запись есть возвращаем ее
        return $model;
    }

    /**
     * Добавить новую карту в базу данных.
     *
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createCard(array $input) : Model
    {
        $model = $this->card->newModelInstance();
        // Заполняем модель
        $model->fill($input);
        $model->save();

        $model = $model->refresh();
        return $model;
    }

     /**
     * Обновить данные определенной карты.
     *
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateCard(string $id, array $input) : Model
    {
        $model = $this->findCard($id);
        $model->fill($input);
        $model->save();

        $model = $model->refresh();
        return $model;
    }

    /**
     * Удалить карту по ID.
     *
     * @param string $id
     * @return bool
     */
    public function removeCardById(string $id) : bool
    {
        // Проверяем существует ли запись
        return $this->findCard($id)->delete();
    }

}
