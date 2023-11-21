<?php

namespace Database\Seeders;

use App\Enum\DefaultRoleType;
use App\Models\Customer;
use App\Models\Spatie\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_20231025_DR_RoleSetWithParticularUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new DatabaseSeeder())->SeederStructure('Seeder_20231025_DR_RoleSetWithParticularUsers', function () {
            DB::beginTransaction();

            // For Administrative User - Guard - web
            Role::create([ // id - 1
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'is_active' => 1
            ]);

            Role::create([ // id - 2
                'name' => 'Admin',
                'guard_name' => 'web',
                'is_active' => 1
            ]);

            // For Staff User - Guard - customer

            Role::create([ // id - 3
                'name' => 'Staff',
                'guard_name' => 'staff',
                'is_active' => 1
            ]);

            foreach (User::all() as $user) {
                if (in_array($user->user_id, ['CLI', 'SYSTEM', 'UN-AUTH', 'USR2300001'])) {
                    $roleID = DefaultRoleType::SUPER_ADMIN->value;
                }

                $user->update([
                    'role_id' => $roleID ?? DefaultRoleType::ADMIN->value,
                ]);

                $user->mergeCasts(['is_active' => 'string']);
                $user->is_active = in_array($user->user_id, ['CLI', 'SYSTEM', 'UN-AUTH']) ? '0' : ($user->getRawOriginal('is_active') === '' ? '0' : $user->getRawOriginal('is_active'));
                $user->save();
            }
        }, $this);
    }
}
