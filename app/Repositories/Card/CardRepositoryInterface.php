<?php

namespace App\Repositories\Card;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface CardRepositoryInterface
{
    public function all() : Collection;
    public function createCard(array $input) : Model;
    public function findCard(string $id) : Model;
    public function removeCardById(string $id) : bool;
    public function getCardsByUser(int $userId) : Collection;
    public function updateCard(string $id, array $input) : Model;
}
