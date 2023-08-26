<?php

namespace App\Services;

use App\Exceptions\CoreException;
use App\Repositories\History\HistoryRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;
use Faker\Factory as Faker;
use AmrShawky\LaravelCurrency\Facade\Currency;

class IntegrationService
{

    /**
     * Получить данные новой карты от платежной системы.
     * Здесь будет интеграция с Visa/Mastercard
     *
     * @return array
     */
    public function getVirtualCard() : array
    {
        // Эмулируем эндпоинт
        $faker = Faker::create();
        // Получаем основные данные карты
        $card = $faker->creditCardDetails();
        // Генерируем трехзначный CVC код
        $card['cvc'] = rand(100, 999);
        // Обновляем номер карты (в соответствии с форматом)
        $card['number'] = chunk_split($card['number'], 4, ' ');
        // Возвращаем результаты
        return $card;
    }

    /**
     * Получить данные новой карты от платежной системы.
     * Здесь будет интеграция с Visa/Mastercard
     *
     * @param string $bankId
     * @return array
     */
    public function getVirtualAccount(string $bankId) : array
    {
        // Эмулируем эндпоинт
        $faker = Faker::create();
        // Получаем данные банка эмитента
        $bankService = app(BankService::class);
        $bank = $bankService->getBank($bankId);
        $countryCode = $bank->country;
        $account = [
            'iban' => $faker->iban($countryCode),
            'bank_id' => $bank->id,
        ];
        // Возвращаем результаты
        return $account;
    }

    /**
     * Получить данные актуального курса валют.
     *
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return array
     */
    public function getCourse(string $from,
                              string $to,
                              float $amount) : float
    {
        return Currency::convert()
            ->from($from)
            ->to($to)
            ->amount($amount)
            ->get();
    }

    /**
     * Получить данные актуальных.
     *
     * @return array
     */
    public function getRates() : array
    {
        return Currency::rates()
            ->latest()
            ->base('RUB')
            ->get();
    }

}
