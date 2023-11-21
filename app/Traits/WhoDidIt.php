<?php

namespace App\Traits;

use App\Models\Common\TableLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class WhoDidIt
{
    protected Request $request;

    /**
     * Blamable constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function creating(Eloquent $model): void
    {
        $this->columExists($model->getTable(), 'created_by') && $model->created_by = $this->userId();
        $this->columExists($model->getTable(), 'updated_by') && $model->updated_by = $this->userId();
    }

    public function updating(Eloquent $model): void
    {
        $this->columExists($model->getTable(), 'updated_by') && $model->updated_by = $this->userId();
    }

    public function deleting(Eloquent $model): void
    {
        $model->deleted_by = $this->doer();
    }

    public function restoring(Eloquent $model): void
    {
        $model->restored_by = $this->doer();
    }

    public function created(Eloquent $model): void
    {
        $this->tableLog($model, 'create');
    }

    public function updated(Eloquent $model): void
    {
        $this->tableLog($model, 'update');
    }

    public function deleted(Eloquent $model): void
    {
        $this->tableLog($model, 'delete');
    }

    public function restored(Eloquent $model): void
    {
        $this->tableLog($model, 'restore');
    }

    public function forceDeleted(Eloquent $model): void
    {
        $this->tableLog($model, 'force-delete');
    }

    protected function columExists($table, $colum): bool
    {
        return Schema::hasColumn($table, $colum);
    }

    protected function doer(): mixed
    {
        return $this->userId() != 'SYSTEM' ? $this->userId() : $this->request->user($this->getGuard())->{$this->getGuard().'_id'};
    }

    protected function userId(): mixed
    {
        if (app()->runningInConsole()) {
            return 'CLI';
        }

        if ($this->getGuard() == 'guest') {
            return 'UN-AUTH';
        }

        if (in_array($this->getGuard(), ['customer', 'supplier'])) {
            return 'SYSTEM';
        }

        return $this->request->user()->user_id;
    }

    protected function tableLog(Model $model, $action): void
    {
        if ($this->tableLogExists()) {
            $lastRecode = TableLog::where(['logable_id' => $model->getKey(), 'logable_type' => get_class($model)])
                ->orderByDesc('id')
                ->limit(1)
                ->select('batch')
                ->first()->batch ?? 0;

            $model->tableLogs()->create([
                'time' => $model->freshTimestamp(),
                'doer' => $this->doer(),
                'user_id' => $this->userId(),
                'guard' => $this->getGuard(),
                'action' => $action,
                'batch' => $lastRecode + 1,
                'transaction_batch' => session('DB_TRANSACTION_BATCH') ?? (TableLog::orderByDesc('id')->where('transaction_batch', '!=', 0)->limit(1)->select('transaction_batch')->first()?->transaction_batch ?? 0) + 1,
                'ip_address' => request()->ip(),
                'via' => request()->segment(1) == 'api' ? 'Mobile' : 'Web',
            ]);
        }
    }

    protected function tableLogExists(): bool
    {
        return Schema::hasTable((new TableLog())->getTable());
    }

    protected function getGuard(): string
    {
        $guards = array_keys(Arr::except(config('auth.guards'), 'sanctum'));
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                $getGuard = $guard;
                break;
            }
        }

        return $getGuard ?? 'guest';
    }
}
