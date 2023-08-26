<?php

namespace App\Services;

use App\Exceptions\CoreException;
use App\Repositories\Account\AccountRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class AccountService
{
    // Комиссия за транзакцию (между картами)
    public float $fee = 0.015;

    public function __construct(
        private AccountRepository $accountRepository
    ){}

    /**
     * Получить список всех банковских счетов.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->accountRepository->all();
    }

    /**
     * Получить список всех банковских счетов,
     * конкретного пользователя.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function my() : Collection
    {
        // Получаем идентификатор пользователя
        $userService = app(UserService::class);
        $userId = $userService->getUserId();
        // Возвращаем список счетов
        return $this->accountRepository->getAccountByUser($userId);
    }

    /**
     * Получить данные определенного банковского счета.
     *
     * @param string $accountId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getAccount(string $accountId) : Model
    {
        return $this->accountRepository->findAccount($accountId);
    }

    /**
     * Отправить средства с одного счета на другой.
     *
     * @param string $accountPayer
     * @param string $accountPayee
     * @param float $amount
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function makeTransaction(string $accountPayer,
                                    string $accountPayee,
                                    float $amount) : Model
    {
        // Подключаем интеграционный сервис
        // (эмуляция конвертера ЦБ РФ)
        $integrationService = app(IntegrationService::class);

        // Получаем данные платежных аккаунтов (валютные коды)
        $payer = $this->accountRepository
                      ->findAccount($accountPayer)
                      ->currency
                      ->code;

        $payee = $this->accountRepository
                      ->findAccount($accountPayee)
                      ->currency
                      ->code;

        // Сумма снятия
        $payerAmount = $amount;
        $payeeAmount = $integrationService->getCourse($payer, $payee, $amount);

        // Списываем средства со счет отправителя
        $this->accountRepository->chargeMoney($accountPayer, $payerAmount);

        // Зачисляем средства на счет получателя
        $this->accountRepository->creditMoney($accountPayee, $payeeAmount);

        // Осущствляем перевод средств (API ЦБ)
        // ...

        // Создаем запись лога транзакций
        $historyService = app(HistoryService::class);
        return $historyService->createHistory($accountPayer,
                                              $accountPayee,
                                              $payer,
                                              $payee,
                                              $payerAmount,
                                              $payeeAmount);
    }

    /**
     * Открыть новый банковский счет.
     *
     * @param string $currencyId
     * @param string|bool $bankId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createAccount(string $currencyId,
                                  string|bool $bankId) : Model
    {
        $userService = app(UserService::class);
        $userId = $userService->getUserId();
        $integrationService = app(IntegrationService::class);
        // Если $bankId = false, значит открывается счет
        // в ЦБ страны банка эмитента (т.е. WALLET).
        $bankService = app(BankService::class);
        $bankId = $bankService->getCentralBank($currencyId)->id;
        // Получаем данные счета
        $account = $integrationService->getVirtualAccount($bankId);
        // Формирование данных записи
        $input = [
            'user_id' => $userId,
            'iban' => $account['iban'],
            'bank_id' => $account['bank_id'],
            'currency_id' => $currencyId
        ];
        // Возвращаем запись из БД
        return $this->accountRepository->createAccount($input);
    }

    /**
     * Проверка есть ли необходимая сумма на счету.
     *
     * @param string $accountId
     * @param float $amount
     * @return bool
     */
    public function isEnough(string $accountId, float $amount) : bool
    {
        return $this->getAccount($accountId)->amount < $amount;
    }

    /**
     * Проверка совпадения юрисдикции двух счетов,
     * через географию банка эмитента.
     *
     * @param string $accountPayer
     * @param string $accountPayee
     * @return bool
     */
    public function checkJurisdiction(string $accountPayer, string $accountPayee) : bool
    {
        // Получаем данные платежных аккаунтов (валютные коды)
        $payer = $this->accountRepository
                      ->findAccount($accountPayer)
                      ->bank
                      ->country;

        $payee = $this->accountRepository
                      ->findAccount($accountPayee)
                      ->bank
                      ->country;

        return $payer == $payee;
    }

    /**
     * Удалить банковский из системы (закрыть).
     *
     * @param string $accountId
     * @return bool
     */
    public function removeAccount(string $accountId) : bool
    {
        return $this->accountRepository->removeAccountById($accountId);
    }

    /**
     * Проверка явлется ли эмитент Российским ЦБ.
     *
     * @param string $accountId
     * @return bool
     */
    public function checkIssuer(string $accountId) : bool
    {
        // Получаем данные платежного аккаунтов (валютный код)
        $issuer = $this->accountRepository
                      ->findAccount($accountId)
                      ->bank
                      ->country;

        return $issuer == 'RUB';
    }

    /**
     * Пополнить счет банковского аккаунта, с
     * использованием пластиковой карты.
     *
     * @param string $accountId
     * @param float $amount
     * @return void
     */
    public function topup(string $accountId, float $amount) : void
    {
        // Проверяем совпадение стран в рамках транзакции
        if(!$this->checkIssuer($accountId)){
            throw new CoreException(Lang::get('wallet.no_main_account'));
        }

        // Зачисляем средства на счет получателя
        $this->accountRepository->creditMoney($accountId, $amount);

    }

}
