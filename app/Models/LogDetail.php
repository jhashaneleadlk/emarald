<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogDetail extends BaseModel
{
    protected $table = 'logs_details';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $guarded = [];

    public function LogMain(): BelongsTo
    {
        return $this->belongsTo(LogMain::class, 'log_id', 'log_id');
    }
}
