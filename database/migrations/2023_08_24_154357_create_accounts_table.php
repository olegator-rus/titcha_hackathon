<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id')
                ->comment('Идентификатор владельца');
            $table->char('iban', 36)
                ->comment('IBAN номер счета');
            $table->char('bank_id', 36)
                ->comment('Идентфиикатор банка эмитента');
            $table->char('currency_id', 36)
                ->comment('Идентификатор валюты счета');
            $table->float('balance')
                ->default(0)
                ->comment('Сумма остатка по счету');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
