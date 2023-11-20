<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Seeder_20220822_DR_UsersDefault extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new DatabaseSeeder())->SeederStructure('Seeder_20220822_DR_UsersDefault', function () {
            User::insert([
                [
                    'user_id' => 'SYSTEM',
                    'first_name' => 'System',
                    'last_name' => 'System',
                    'email' => 'SYSTEM',
                    'email_verified_at' => null,
                    'phone' => 'SYSTEM',
                    'password' => '',
                    'is_active' => 0,
                    'role_id' => 1,
                    'uuid' => Str::uuid()->toString(),
                    'created_by' => 'CLI',
                    'updated_by' => 'CLI',
                ],
                [
                    'user_id' => 'CLI',
                    'first_name' => 'Command Line',
                    'last_name' => 'Line',
                    'email' => 'Command Line',
                    'email_verified_at' => null,
                    'phone' => 'Command Line',
                    'password' => '',
                    'is_active' => 0,
                    'role_id' => 1,
                    'uuid' => Str::uuid()->toString(),
                    'created_by' => 'CLI',
                    'updated_by' => 'CLI',
                ],
                [
                    'user_id' => 'UN-AUTH',
                    'first_name' => 'UN-AUTH',
                    'last_name' => 'UN-AUTH',
                    'email' => 'UN-AUTH',
                    'email_verified_at' => null,
                    'phone' => 'UN-AUTH',
                    'password' => '',
                    'is_active' => 0,
                    'role_id' => 1,
                    'uuid' => Str::uuid()->toString(),
                    'created_by' => 'CLI',
                    'updated_by' => 'CLI',
                ],
            ]);
        }, $this);
    }
}
