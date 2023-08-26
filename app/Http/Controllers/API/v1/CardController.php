<?php

namespace App\Http\Controllers\API\v1;

use App\Services\CardService;
use Illuminate\Http\Request;
use App\Traits\JsonResponds;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class CardController extends Controller
{
    // Подключаем трейт ответов
    use JsonResponds;

    /**
     * Получить список всех карт.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\CardService $cardService
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request,
                        CardService $cardService) : Response
    {
        try
        {
            $cards = $cardService->all();

            return $this->success(
                Lang::get('cards.all'),
                $cards
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Получить список всех карт текущего пользователя.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\CardService $cardService
     * @return \Illuminate\Http\Response
     */
    public function my(Request $request,
                       CardService $cardService) : Response
    {
        try
        {
            $cards = $cardService->my();

            return $this->success(
                Lang::get('cards.my'),
                $cards
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Найти определенный кошелек по ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\CardService $cardService
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request,
                        CardService $cardService) : Response
    {
        try
        {
            // Получаем идентификатор кошелька
            $cardId = (string) $request->id;
            $card = $cardService->getCard($cardId);

            return $this->success(
                Lang::get('card.get'),
                $card
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }


    /**
     * Добавить карту в систему.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\CardService $cardService
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,
                           CardService $cardService) : Response
    {
        DB::beginTransaction();
        try
        {
            $currencyId = (string) $request->currencyId;
            $bankId = (string) $request->bankId;
            // Вызываем сервис создания карты
            $data = $cardService->createCard($currencyId, $bankId);
            // Завершаем транзакцию
            DB::commit();
            // Возвращаем ответ
            return $this->success(
                Lang::get('card.created'),
                $data
            );
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Перевод между кошельками и картами,
     * а также картами и картами. В пределах
     * банковской системы одной страны.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\CardService $cardService
     * @return \Illuminate\Http\Response
     */
    public function transaction(Request $request,
                                CardService $cardService) : Response
    {
        DB::beginTransaction();
        try
        {
            // Получаем данные для осуществления внутрененй транзакции
            $accountPayer = (string) $request->accountPayer;
            $accountPayee = (string) $request->accountPayee;
            $amount = (float) $request->amount;

            // Вызываем сервис перевода транзакции
            $data = $cardService->transaction(
                $accountPayer,
                $accountPayee,
                $amount
            );
            // Завершаем транзакцию
            DB::commit();
            // Отправляем ответ
            return $this->success(
                Lang::get('card.delivered'),
                $data
            );
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Удалить карту по индентификатору.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\CardService $cardService
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request,
                           CardService $cardService) : Response
    {
        DB::beginTransaction();
        try
        {
            // Получаем идентификатор мероприятия
            $cardId = (string) $request->id;
            // Удаляем карту из системы
            $data = $cardService->removeCard($cardId);
            // Завершаем транзакцию
            DB::commit();
            return $this->success(
                Lang::get('card.removed'),
                $data
            );
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }

}
