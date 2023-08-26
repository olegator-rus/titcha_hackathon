<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrenciesSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run() : void
    {
        Currency::create([
            'id' => '0fe31453-112a-4638-b539-734d838e0021',
            'name' => 'Рубль',
            'code' => 'RUB',
        ]);

        Currency::create([
            'id' => 'a23c21e5-6556-49b9-9cfc-e2ba31cc7adf',
            'name' => 'Юань',
            'code' => 'CNY',
        ]);

        // Currency::create([
        //     'id' => '9535ae52-881a-49bf-a8db-18b536426012',
        //     'name' => 'Доллар США',
        //     'code' => 'USD',
        // ]);

        // Currency::create([
        //     'id' => '9535ae52-881a-49bf-a8db-18b536426012',
        //     'name' => 'Тенге',
        //     'code' => 'KZT',
        // ]);

    }

}
