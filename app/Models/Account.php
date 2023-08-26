<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Account extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'iban',
        'bank_id',
        'currency_id',
        'balance'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Отношение для получения валютного кода
    public function currency() : HasOne
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }


    // Отношение для получения платежного счета
    public function bank() : HasOne
    {
        return $this->hasOne(Bank::class, 'id', 'bank_id');
    }

    // Отношение для получения данных пользователя
    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    // Отношение для получения платежного счета
    public function card() : HasOne
    {
        return $this->hasOne(Card::class, 'account_id', 'id');
    }

    // Отношение для получения платежного счета
    public function wallet() : HasOne
    {
        return $this->hasOne(Wallet::class, 'account_id', 'id');
    }
}
