<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Common\PrimaryKeyInfo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Seeder_20220822_DR_UsersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new DatabaseSeeder())->SeederStructure('Seeder_20220822_DR_UsersTable', function () {
            PrimaryKeyInfo::create([
                'key' => 'USR',
                'model' => "App\Models\User",
                'prefix' => 'USR%%Y%%',
                'field' => 'user_id',
                'numbof_chars' => 5,
                'pad_sym' => '0',
                'last_prkey' => '',
                'uuid' => Str::uuid()->toString(),
            ]);

            $primary_key = Helper::genPrimaryID('USR');

            $userAdmin = [
                'user_id' => $primary_key,
                'first_name' => 'SUPER',
                'last_name' => 'ADMIN',
                'email' => 'super@emaralcare.nz',
                'email_verified_at' => now(),
                'phone' => '0000000000',
                'password' => Hash::make('Admin@123'),
                'uuid' => Str::uuid()->toString(),
                'role_id' => 1,
                'is_active' => '1',
                'created_by' => 'CLI',
                'updated_by' => 'CLI',
            ];
            User::create($userAdmin);
        }, $this);
    }
}
