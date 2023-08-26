<?php

namespace App\Repositories\Bank;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BankRepositoryInterface
{
    public function all() : Collection;
    public function createBank(array $input) : Model;
    public function findBank(string $id) : Model;
    public function removeBankById(string $id) : bool;
    public function updateBank(string $id, array $input) : Model;
    public function findCentralBank(string $currencyId) : Model;
}
