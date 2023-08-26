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

class FraudService
{

    /**
     * Найти аномальные транзкции и вернуть их ID.
     *
     * @param \Illuminate\Database\Eloquent\Collection $history
     * @return array
     */
    public function findAnomaly(Collection $history) : array
    {
        // Аномальные признаки:
        // (1) Сильно большая траназакция по сравнению со средним значением (+20%)
        // (2) Аномалии стандартного IP адреса
        // (3) Аномалии получателя (выбивается из списка)
        // (4) Время отправления транзакции аномалии
        $forest = new \Rcf\Forest(1);
        $max = $history->max('amount_payer');
        foreach ($history as $key => $value) {
            $point = [];
            // Не забываем нормировку
            $point[0] = $value->amount_payer / $max;

            $value->score = $forest->score($point);
            $forest->update($point);
        }

        $history->each(function ($item, $key){
            // Флаг аномалии
            $item['isStrange'] = $item['score'] > 1.6 ? true : false;
        });

        return $history->toArray();
    }

}
