<?php

namespace App\Listeners;

use Illuminate\Database\Events\TransactionCommitted;

class DestroyTransactionBatch
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
    public function handle(TransactionCommitted $event): void
    {
        session()->forget('DB_TRANSACTION_BATCH');
    }
}
