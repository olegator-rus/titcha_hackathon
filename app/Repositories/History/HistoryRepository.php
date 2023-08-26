<?php

namespace App\Repositories\History;

use App\Exceptions\CoreException;
use App\Models\History;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class HistoryRepository implements HistoryRepositoryInterface
{

    public function __construct(
        private History $history
    ){}

    /**
     * Список всех кошельков.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->history->get();
    }

    /**
     * Список всех транзакций.
     *
     * @param array $accounts
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAccountsHistory(array $accounts) : Collection
    {
        return $this->history
            ->whereIn('account_payer', $accounts)
            ->orWhereIn('account_payee', $accounts)
            ->with(['payer', 'payee'])
            ->get();
    }

    /**
     * Добавить новый лог.
     *
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createHistory(array $input) : Model
    {
        $model = $this->history->newModelInstance();
        // Заполняем модель
        $model->fill($input);
        $model->save();

        $model = $model->refresh();
        return $model;
    }

}
