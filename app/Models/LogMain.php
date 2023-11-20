<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class LogMain extends BaseModel
{
    protected $table = 'logs';

    protected $primaryKey = 'log_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function LogDetails(): HasMany
    {
        return $this->hasMany(LogDetail::class, 'log_id', 'log_id');
    }
}
