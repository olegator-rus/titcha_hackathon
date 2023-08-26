<?php

namespace App\Services;

use App\Exceptions\CoreException;
use App\Repositories\Bank\BankRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class BankService
{
    public function __construct(
        private BankRepository $bankRepository
    ){}

    /**
     * Получить список всех карт.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->bankRepository->all();
    }

    /**
     * Получить данные определенного банка.
     *
     * @param string $bankId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getBank(string $bankId) : Model
    {
        return $this->bankRepository->findBank($bankId);
    }

    /**
     * Получить данные центрального банка,
     * по коду валюты.
     *
     * @param string $currencyId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getCentralBank(string $currencyId) : Model
    {
        return $this->bankRepository
                    ->findCentralBank($currencyId);
    }

    /**
     * Создать банк в системе.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createBank() : Model
    {
        $userService = app(UserService::class);
        $userId = $userService->getUserId();
        // Формирование данных записи
        $input = [
            'user_id' => $userId,
        ];
        // Возвращаем запись из БД
        return $this->bankRepository->createBank($input);
    }

    /**
     * Обновить данные банка в системе.
     *
     * @param string $bankId
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateBank(string $bankId,
                               Request $request) : Model
    {
        // Оставляем для обновления все, кроме ID
        $input = $request->except(['id']);
        // Обновляем зал (локацию)
        $bank = $this->bankRepository->updateBank($bankId, $input);
        // Возвращаем данные зала
        return $bank;
    }

    /**
     * Удалить банк из системы.
     *
     * @param string $bankId
     * @return bool
     */
    public function removeBank(string $bankId) : bool
    {
        return $this->bankRepository->removeBankById($bankId);
    }
}
