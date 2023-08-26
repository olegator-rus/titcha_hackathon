<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class History extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_payer',
        'account_payee',
        'currency_payer',
        'currency_payee',
        'amount_payer',
        'amount_payee',
        'ip',
    ];

    // Отношение для получения аккаунта плательщика
    public function payer() : HasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_payer')
                    ->with(['user']);
    }

    // Отношение для получения аккаунта получателя
    public function payee() : HasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_payee')
                    ->with(['user']);
    }

}
