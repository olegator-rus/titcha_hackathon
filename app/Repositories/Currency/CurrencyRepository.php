<?php

namespace App\Repositories\Currency;

use App\Exceptions\CoreException;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Lang;

class CurrencyRepository implements CurrencyRepositoryInterface
{

    public function __construct(
        private Currency $currency
    ){}

    /**
     * Список всех валют.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->currency->get();
    }

}
