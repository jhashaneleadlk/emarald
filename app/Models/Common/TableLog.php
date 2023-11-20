<?php

namespace App\Models\Common;

use App\Models\Customer;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TableLog extends Model
{
    protected $table = 'table_logs';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'time' => 'datetime',
    ];

    public static array $actionNamesAndColor = [
        'login' => 'success',
        'logout' => 'dark',
        'create' => 'primary',
        'update' => 'info',
        'delete' => 'light',
        'restore' => 'warning',
        'force-delete' => 'danger',
    ];

    public function logable(): MorphTo
    {
        return $this->morphTo();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'doer', 'customer_id')->withTrashed();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id')->withTrashed();
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'doer', 'supplier_id')->withTrashed();
    }
}
