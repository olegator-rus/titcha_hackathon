<?php

namespace App\Repositories\Account;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface AccountRepositoryInterface
{
    public function all() : Collection;
    public function chargeMoney($accountPayer, $amount) : Model;
    public function createAccount(array $input) : Model;
    public function creditMoney($accountPayee, $amount) : Model;
    public function findAccount(string $id) : Model;
    public function removeAccountById(string $id) : bool;
    public function getAccountByUser(int $userId) : Collection;
}
