<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Common\PrimaryKeyInfo;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Seeder_20220822_DR_StaffsTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new DatabaseSeeder())->SeederStructure('Seeder_20220822_DR_StaffsTable', function () {
            PrimaryKeyInfo::create([
                'key' => 'STAFF',
                'model' => "App\Models\Staff",
                'prefix' => 'STAFF%%Y%%',
                'field' => 'staff_id',
                'numbof_chars' => 5,
                'pad_sym' => '0',
                'last_prkey' => '',
                'uuid' => Str::uuid()->toString(),
            ]);

            $primary_key = Helper::genPrimaryID('STAFF');

            $staffOne = [
                'staff_id' => $primary_key,
                'name' => 'STAFF',
                'email' => 'staff@emaraldcare.nz',
                'email_verified_at' => now(),
                'phone' => '0000000000',
                'password' => Hash::make('Admin@123'),
                'contact_person' =>'hash',
                'role_id' => 1,
                'is_active' => '1',
                'created_by' => 'CLI',
                'updated_by' => 'CLI',
            ];
            Staff::create($staffOne);
        }, $this);
    }
}
