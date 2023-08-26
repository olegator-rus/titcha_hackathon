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
        Schema::create('cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id')
                ->comment('Идентификатор пользователя');
            $table->char('account_id', 36)
                ->comment('Привязанный счет');
            $table->string('number')
                ->comment('Номер карты');
            $table->string('cardholder')
                ->comment('Фамилия и имя владелец карты');
            $table->string('expiration_date')
                ->comment('Дата истечения срока');
            $table->string('type')
                ->comment('Тип платежной системы');
            $table->char('cvc', 3)
                ->comment('CVC код карточки');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
