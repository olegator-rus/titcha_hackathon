<?php

namespace App\Repositories\Currency;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface CurrencyRepositoryInterface
{
    public function all() : Collection;
}
