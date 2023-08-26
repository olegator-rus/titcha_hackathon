<?php

namespace App\Services;

use App\Exceptions\CoreException;
use App\Repositories\Currency\CurrencyRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class CurrencyService
{
    public function __construct(
        private CurrencyRepository $currencyRepository
    ){}

    /**
     * Получить список всех валют.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->currencyRepository->all();
    }
}
