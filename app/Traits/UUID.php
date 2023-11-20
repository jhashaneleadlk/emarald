<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UUID
{
    public function creating(Model $model): void
    {
        $model->uuid = Str::uuid();
    }
}
