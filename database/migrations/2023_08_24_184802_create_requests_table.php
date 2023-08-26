<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->ipAddress('ip')
                ->comment('IP адрес пользователя осуществившего запрос');
            $table->string('url')
                ->comment('Точка осуществления запроса');
            $table->string('method')
                ->comment('Метод используемый при запросе');
            $table->text('params')
                ->comment('Параметры передаваемые на сервер');
            $table->text('user_agent')
                ->comment('Данные об устройстве пользователя');
            $table->unsignedBigInteger('user_id')
                ->nullable()
                ->comment('Идентификатор пользователя');
            $table->float('execute_time')
                ->comment('Время работы эндпоинта');
            $table->timestamp('time')
                ->comment('Дата и время записи лога');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('requests');
        Schema::enableForeignKeyConstraints();
    }
};
