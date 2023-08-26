<?php

namespace App\Services;

use App\Exceptions\CoreException;
use App\Repositories\Wallet\WalletRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class WalletService
{
    public function __construct(
        private WalletRepository $walletRepository
    ){}

    /**
     * Получить список всех кошельков.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->walletRepository->all();
    }

    /**
     * Получить список всех кошельков,
     * авторизированного пользователя.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function my() : Collection
    {
        $userService = app(UserService::class);
        $userId = $userService->getUserId();
        return $this->walletRepository->getWalletsByUser($userId);
    }

    /**
     * Проверка есть ли необходимая сумма на кошельке.
     *
     * @param string $accountId
     * @param float $amount
     * @return bool
     */
    public function isEnough(string $accountId, float $amount) : bool
    {
        // Так как кошелек привязан к сущности счета,
        // напрямую проверяем наличие средств на счете.
        $accountService = app(AccountService::class);
        return $accountService->isEnough($accountId, $amount);
    }

    /**
     * Получить данные определенного кошелька.
     *
     * @param string $walletId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getWallet(string $walletId) : Model
    {
        return $this->walletRepository->findWallet($walletId);
    }

    /**
     * Открыть новый кошелек в определенной валюте.
     *
     * @param string $currencyId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createWallet(string $currencyId) : Model
    {
        $userService = app(UserService::class);
        $userId = $userService->getUserId();
        // Создаем банковский счет
        $accountService = app(AccountService::class);
        $account = $accountService->createAccount($currencyId, false);
        // Формирование данных записи
        $input = [
            'user_id' => $userId,
            'bank_id' => $account->bank_id,
            'account_id' => $account->id
        ];
        // Возвращаем запись из БД
        return $this->walletRepository->createWallet($input);
    }

    /**
     * Отправить средства с одного кошелька
     * на другой кошелек.
     *
     * @param string $walletPayer
     * @param string $walletPayee
     * @param float $amount
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function walletToWallet(string $walletPayer,
                                   string $walletPayee,
                                   float $amount) : Model
    {

        // Получаем связанный счет отправителя кошелька
        $accountPayer = $this->getWallet($walletPayer)
                             ->account_id;

        // Получаем связанный счет получателя кошелька
        $accountPayee = $this->getWallet($walletPayee)
                             ->account_id;

        // Проверяем наличие средств на счете
        if(!$this->isEnough($accountPayer, $amount)){
            throw new CoreException(Lang::get('wallet.not_enough_money'));
        }

        // Списываем деньги со счета
        $accountService = app(AccountService::class);

        return $accountService->makeTransaction(
            $accountPayer,
            $accountPayee,
            $amount
        );
    }

    /**
     * Удалить кошелек из системы.
     *
     * @param string $walletId
     * @return bool
     */
    public function removeWallet(string $walletId) : bool
    {
        return $this->walletRepository->removeWalletById($walletId);
    }
}
