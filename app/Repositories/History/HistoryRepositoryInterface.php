<?php

namespace App\Repositories\History;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface HistoryRepositoryInterface
{
    public function all() : Collection;
    public function createHistory(array $input) : Model;
    public function getAccountsHistory(array $accounts) : Collection;
}
