<?php

namespace App\Http\Controllers\API\v1;

use App\Services\HistoryService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Traits\JsonResponds;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class HistoryController extends Controller
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
    public function my(Request $request,
                       HistoryService $historyService) : Response
    {
        try
        {
            $history = $historyService->my();

            return $this->success(
                Lang::get('history.my'),
                $history
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

}
