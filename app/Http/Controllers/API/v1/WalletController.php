<?php

namespace App\Http\Controllers\API\v1;

use App\Services\WalletService;
use Illuminate\Http\Request;
use App\Traits\JsonResponds;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class WalletController extends Controller
{
    // Подключаем трейт ответов
    use JsonResponds;

    /**
     * Получить список всех кошельков.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\WalletService $walletService
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request,
                        WalletService $walletService) : Response
    {
        try
        {
            $wallets = $walletService->all();

            return $this->success(
                Lang::get('wallets.all'),
                $wallets
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Получить список всех кошельков текущего пользователя.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\WalletService $walletService
     * @return \Illuminate\Http\Response
     */
    public function my(Request $request,
                       WalletService $walletService) : Response
    {
        try
        {
            $wallets = $walletService->my();

            return $this->success(
                Lang::get('wallets.my'),
                $wallets
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
     * @param \App\Services\WalletService $walletService
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request,
                        WalletService $walletService) : Response
    {
        try
        {
            // Получаем идентификатор кошелька
            $walletId = (string) $request->id;
            $wallet = $walletService->getWallet($walletId);

            return $this->success(
                Lang::get('wallet.get'),
                $wallet
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }


    /**
     * Добавить мероприятие в систему.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\WalletService $WalletService
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,
                           WalletService $walletService) : Response
    {
        DB::beginTransaction();
        try
        {
            $currencyId = (string) $request->id;
            // Вызываем сервис создания кошелька
            $data = $walletService->createWallet($currencyId);
            // Завершаем транзакцию
            DB::commit();
            // Удаляем работу
            return $this->success(
                Lang::get('wallet.created'),
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
     * Перевод между кошельками.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\WalletService $WalletService
     * @return \Illuminate\Http\Response
     */
    public function transaction(Request $request,
                                WalletService $walletService) : Response
    {
        DB::beginTransaction();
        try
        {
            // Получаем данные для осуществления внутрененй транзакции
            $accountPayer = (string) $request->accountPayer;
            $accountPayee = (string) $request->accountPayee;
            $amount = (float) $request->amount;
            // Вызываем сервис перевода транзакции
            $data = $walletService->walletToWallet(
                $accountPayer,
                $accountPayee,
                $amount
            );
            // Завершаем транзакцию
            DB::commit();
            // Отправляем ответ
            return $this->success(
                Lang::get('wallet.delivered'),
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
