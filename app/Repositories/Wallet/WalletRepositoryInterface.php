<?php

namespace App\Repositories\Wallet;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface WalletRepositoryInterface
{
    public function all() : Collection;
    public function createWallet(array $input) : Model;
    public function findWallet(string $id) : Model;
    public function removeWalletById(string $id) : bool;
    public function getWalletsByUser(int $userId) : Collection;
    public function updateWallet(string $id, array $input) : Model;
}
