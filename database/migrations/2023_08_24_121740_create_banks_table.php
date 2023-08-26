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
        Schema::create('banks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')
                ->comment('Название банка-эмитента');
            $table->string('country')
                ->comment('Страна банка-эмитента');
            $table->string('address')
                ->comment('Страна банка-эмитента');
            $table->string('swift_code')
                ->comment('SWIFT код банка-эмитента');
            $table->string('iban')
                ->comment('IBAN банка-эмитента');
            $table->string('TIN')
                ->comment('ИНН банка-эмитента');
            $table->boolean('is_central')
                ->default(false)
                ->comment('Отметка ЦБ банка страны кошелька');
            $table->char('currency_id', 36)
                ->comment('Код валюты, применимо для ЦБ');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
