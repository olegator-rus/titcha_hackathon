<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;
use Illuminate\Support\Facades\Storage;

class BanksSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run() : void
    {
        // ЦБ РФ
        Bank::create([
            'name' => 'Центральй Банк России',
            'country' => 'RUB',
            'address' => 'Москва, Сандуновский пер., д. 3, стр. 1',
            'swift_code' => 'VTBRRUMM',
            'iban' => '30109036100000000001',
            'TIN' => '7702235133',
            'is_central' => true,
            'currency_id' => '0fe31453-112a-4638-b539-734d838e0021',
        ]);

        // Коммерческий банк РФ
        Bank::create([
            'name' => 'Акционерное общество «Тинькофф Банк»',
            'country' => 'RUB',
            'address' => '127287, г. Москва, ул. Хуторская 2-я, д. 38А, стр. 26',
            'swift_code' => 'TICSRUMM',
            'iban' => '30232810100000000004',
            'TIN' => '7710140679',
            'is_central' => false,
            'currency_id' => '0fe31453-112a-4638-b539-734d838e0021',
        ]);

        // ЦБ Китая
        Bank::create([
            'name' => 'Народный Банк Китая',
            'country' => 'CNY',
            'address' => 'Гуанмин, улица Лянмацяо № 42, район Чаоян, Пекин, 100125, КНР',
            'swift_code' => 'СHCGCBMM',
            'iban' => '92166636100000000001',
            'TIN' => '828374729238348291839000',
            'is_central' => true,
            'currency_id' => 'a23c21e5-6556-49b9-9cfc-e2ba31cc7adf',
        ]);

        // Коммерческий банк Китая
        Bank::create([
            'name' => 'Индустриальный банк Китая',
            'country' => 'CNY',
            'address' => 'Тайвань, улица Лянмацяо № 42, район Чаоян, Пекин, 100125, КНР',
            'swift_code' => 'TAPGGUMM',
            'iban' => '992883720100000000004',
            'TIN' => '102374729238348291839000',
            'is_central' => false,
            'currency_id' => 'a23c21e5-6556-49b9-9cfc-e2ba31cc7adf',
        ]);

    }

}
