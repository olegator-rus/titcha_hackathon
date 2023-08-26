<?php

namespace App\Http\Controllers\API\v1;

use App\Services\CurrencyService;
use App\Services\IntegrationService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Traits\JsonResponds;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class CurrencyController extends Controller
{
    // Подключаем трейт ответов
    use JsonResponds;

    /**
     * Получить список всех валют.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\CurrencyService $currencyService
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request,
                        CurrencyService $currencyService) : Response
    {
        try
        {
            $currencies = $currencyService->all();

            return $this->success(
                Lang::get('currency.all'),
                $currencies
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Получить текущие курсы валют.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\IntegrationService $integrationService
     * @return \Illuminate\Http\Response
     */
    public function rates(Request $request,
                          IntegrationService $integrationService) : Response
    {
        try
        {
            $currencies = $integrationService->getRates();

            return $this->success(
                Lang::get('currency.all'),
                $currencies
            );
        }
        catch(\Exception $e)
        {
            return $this->failure($e->getMessage());
        }
    }

}
