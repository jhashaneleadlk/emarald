<?php

namespace Database\Seeders;

use App\Models\Common\PrimaryKeyInfo;
use Illuminate\Database\Seeder;

class Seeder_20220823_DR_SystemBasics extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new DatabaseSeeder())->SeederStructure('Seeder_20220823_DR_SystemBasics', function () {
            PrimaryKeyInfo::create([
                'key' => 'LOGID',
                'model' => "App\Models\LogMain",
                'prefix' => 'LOGID%%Y%%',
                'field' => 'log_id',
                'numbof_chars' => 5,
                'pad_sym' => '0',
                'last_prkey' => '',
            ]);
            PrimaryKeyInfo::create([
                'key' => 'LOG',
                'model' => "App\Models\LogMain",
                'prefix' => 'LOG%%Y%%',
                'field' => 'staff_id',
                'numbof_chars' => 5,
                'pad_sym' => '0',
                'last_prkey' => '',
            ]);
        }, $this);
    }
}
