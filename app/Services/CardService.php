<?php

namespace App\Services;

use App\Exceptions\CoreException;
use App\Repositories\Card\CardRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class CardService
{
    public function __construct(
        private CardRepository $cardRepository
    ){}

    /**
     * Получить список всех карт.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->cardRepository->all();
    }

    /**
     * Получить данные определенной карты.
     *
     * @param string $cardId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getCard(string $cardId) : Model
    {
        return $this->cardRepository->findCard($cardId);
    }

    /**
     * Получить список всех карт,
     * авторизированного пользователя.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function my() : Collection
    {
        $userService = app(UserService::class);
        $userId = $userService->getUserId();
        return $this->cardRepository->getCardsByUser($userId);
    }

    /**
     * Открыть новую карту.
     *
     * @param string $currencyId
     * @param string $bankId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createCard(string $currencyId,
                               string $bankId) : Model
    {
        $userService = app(UserService::class);
        $userId = $userService->getUserId();
        $integrationService = app(IntegrationService::class);
        $card = $integrationService->getVirtualCard();
        // Создаем банковский счет
        $accountService = app(AccountService::class);
        $account = $accountService->createAccount($currencyId, $bankId);
        // Формирование данных записи
        $input = [
            'account_id' => $account->id,
            'cardholder' => $card['name'],
            'cvc' => $card['cvc'],
            'expiration_date' => $card['expirationDate'],
            'expiration' => $card['expirationDate'],
            'number' => $card['number'],
            'type' => $card['type'],
            'user_id' => $userId,
        ];
        // Возвращаем запись из БД
        return $this->cardRepository->createCard($input);
    }

    /**
     * Отправить средства с одного счета на другой,
     * привязанный к карте и/или счету в пределах одной страны.
     *
     * @param string $accountPayer
     * @param string $accountPayee
     * @param float $amount
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function transaction(string $accountPayer,
                                string $accountPayee,
                                float $amount) : Model
    {

        $accountService = app(AccountService::class);

        // Проверяем наличие средств на счете
        if(!$accountService->isEnough($accountPayer, $amount)){
            throw new CoreException(Lang::get('account.not_enough_money'));
        }

        // Проверяем совпадение стран в рамках транзакции
        if(!$accountService->checkJurisdiction($accountPayer, $accountPayee)){
            throw new CoreException(Lang::get('account.wrong_jurisdiction'));
        }

        // Списываем деньги со счета
        return $accountService->makeTransaction(
            $accountPayer,
            $accountPayee,
            $amount
        );
    }

    /**
     * Удалить карту из системы.
     *
     * @param string $cardId
     * @return bool
     */
    public function removeCard(string $cardId) : bool
    {
        return $this->cardRepository->removeCardById($cardId);
    }
}
