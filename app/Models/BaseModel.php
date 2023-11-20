<?php

namespace App\Models;

use App\Models\Common\TableLog;
use App\Traits\UUIDTrait;
use App\Traits\WhoDidItTrait;
use DDZobov\PivotSoftDeletes\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BaseModel extends Model
{
    use UUIDTrait;
    use WhoDidItTrait;

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function tableLogs(): MorphMany
    {
        return $this->morphMany(TableLog::class, 'logable');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id')->withTrashed();
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'user_id')->withTrashed();
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by', 'user_id')->withTrashed();
    }

    public function restoredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'restored_by', 'user_id')->withTrashed();
    }
}
