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
        Schema::create('histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->char('account_payer', 36)
                ->comment('Идентификатор отправителя перевода');
            $table->char('account_payee', 36)
                ->comment('Идентификатор получателя перевода');

            $table->char('currency_payer', 36)
                ->comment('Валюта перевода');
            $table->char('currency_payee', 36)
                ->comment('Валюта получения');

            $table->float('amount_payer', 36)
                ->comment('Сумма в валюте отправителя');
            $table->float('amount_payee', 36)
                ->comment('Сумма в валюте получателя');

            $table->ipAddress('ip')
                ->comment('IP адрес транзакции');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
