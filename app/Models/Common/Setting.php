<?php

namespace App\Models\Common;

use App\Models\BaseModel;
use App\Models\Franchise\Franchise;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends BaseModel
{
    protected $table = 'settings';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $guarded = [];

    public function franchise(): BelongsTo
    {
        return $this->belongsTo(Franchise::class, 'franchise_id', 'id');
    }
}
