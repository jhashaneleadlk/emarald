<?php

namespace App\Enum;

use App\Models\Spatie\Role;

enum DefaultRoleType: int
{
    case SUPER_ADMIN = 1;
    case ADMIN = 2;

    case STAFF = 3;

    public function toString(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => Role::find(self::SUPER_ADMIN->value)->name,
            self::ADMIN => Role::find(self::ADMIN->value)->name,
            self::STAFF => Role::find(self::STAFF->value)->name,
        };
    }
}
