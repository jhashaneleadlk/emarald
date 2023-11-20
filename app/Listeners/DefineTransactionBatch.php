<?php

namespace App\Listeners;

use App\Models\Common\TableLog;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Support\Facades\Schema;

class DefineTransactionBatch
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionBeginning $event): void
    {
        if (Schema::hasTable((new TableLog())->getTable())) {
            $transactionBatch = TableLog::orderByDesc('id')->first()->transaction_batch ?? 0;
            session(['DB_TRANSACTION_BATCH' => ++$transactionBatch]);
        }
    }
}
