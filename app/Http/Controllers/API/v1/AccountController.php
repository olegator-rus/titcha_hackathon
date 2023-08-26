<?php

namespace App\Http\Controllers\API\v1;

use App\Services\AccountService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Traits\JsonResponds;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class AccountController extends Controller
{
    // Подключаем трейт ответов
    use JsonResponds;

    /**
     * Получить аккаунты по ID владельца.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\AccountService $accountService
     * @return \Illuminate\Http\Response
     */
    public function my(Request $request,
                       AccountService $accountService) : Response
    {
        try
        {
            $bank = $accountService->my();

            return $this->success(
                Lang::get('account.my'),
                $bank
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Пополнение счета на сайте.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\AccountService $accountService
     * @return \Illuminate\Http\Response
     */
    public function topup(Request $request,
                          AccountService $accountService) : Response
    {
        DB::beginTransaction();
        try
        {
            $accountId = (string) $request->accountId;
            $amount = (float) $request->amount;
            // Вызываем сервис пополнения основного российского счета
            $data = $accountService->topup(
                $accountId,
                $amount
            );
            // Завершаем транзакцию
            DB::commit();
            // Отправляем ответ
            return $this->success(
                Lang::get('account.topuped'),
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
