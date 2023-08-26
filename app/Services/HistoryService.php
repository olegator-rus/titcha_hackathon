<?php

namespace App\Services;

use App\Exceptions\CoreException;
use App\Repositories\History\HistoryRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class HistoryService
{
    public function __construct(
        private HistoryRepository $historyRepository
    ){}

    /**
     * Получить список всех историй транзакций.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->historyRepository->all();
    }

    /**
     * Получить список всех историй транзакций.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function my() : Collection
    {
        // Получаем список аккаунтов
        $accountService = app(AccountService::class);
        $accounts = $accountService->my()
            ->pluck('id')
            ->toArray();
        $history = $this->historyRepository
            ->getAccountsHistory($accounts);

        $fraudService = app(FraudService::class);
        dd($fraudService->findAnomaly($history));
        return $history;

    }

    /**
     * Открыть новый банковский счет.
     *
     * @param string $accountPayer
     * @param string $accountPayee
     * @param string $currencyPayer
     * @param string $currencyPayee
     * @param string $amountPayer
     * @param string $amountPayee
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createHistory(string $accountPayer,
                                  string $accountPayee,
                                  string $currencyPayer,
                                  string $currencyPayee,
                                  float $amountPayer,
                                  float $amountPayee) : Model
    {
        // Формирование данных записи
        $input = [
            // Отправитель и получатель
            'account_payer' => $accountPayer,
            'account_payee' => $accountPayee,
            // Валюты транзакции
            'currency_payer' => $currencyPayer,
            'currency_payee' => $currencyPayee,
            // Контрольные суммы
            'amount_payer' => $amountPayer,
            'amount_payee' => $amountPayee,
            // IP адрес пользователя
            'ip' => Request::ip(),
        ];
        // Возвращаем запись из БД
        return $this->historyRepository->createHistory($input);
    }

}
