<?php

namespace App\Http\Controllers\API\v1;

use App\Services\BankService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Traits\JsonResponds;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class BankController extends Controller
{
    // Подключаем трейт ответов
    use JsonResponds;

    /**
     * Получить список всех банков.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\BankService $bankService
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request,
                        BankService $bankService) : Response
    {
        try
        {
            $banks = $bankService->all();

            return $this->success(
                Lang::get('bank.all'),
                $banks
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Найти определенный банк по ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\BankService $bankService
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request,
                        BankService $bankService) : Response
    {
        try
        {
            // Получаем идентификатор банка
            $bankId = (string) $request->id;
            $bank = $bankService->getBank($bankId);

            return $this->success(
                Lang::get('bank.get'),
                $bank
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }


    /**
     * Добавить банк в систему.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\BankService $bankService
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,
                           BankService $bankService) : Response
    {
        DB::beginTransaction();
        try
        {
            // Вызываем сервис создания банка
            $data = $bankService->createBank();
            // Завершаем транзакцию
            DB::commit();
            return $this->success(
                Lang::get('bank.created'),
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
     * Обновить данные мероприятия.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\BankService $bankService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,
                           BankService $bankService) : Response
    {
        DB::beginTransaction();
        try
        {
            // Определяем ID банка для обновления
            $bankId = (string) $request->id;

            // Обновляем данные
            $bank = $bankService->updateBank($bankId, $request);

            // Завершаем транзакцию
            DB::commit();
            // Возвращаем статус и данные
            return $this->success(
                Lang::get('bank.update'),
                $bank
            );

        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Удалить банк по индентификатору.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\BankService $bankService
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request,
                           BankService $bankService) : Response
    {
        DB::beginTransaction();
        try
        {
            // Получаем идентификатор банка
            $bankId = (string) $request->id;
            // Удаляем банк
            $data = $bankService->removeBank($bankId);
            // Завершаем транзакцию
            DB::commit();
            return $this->success(
                Lang::get('bank.removed'),
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
