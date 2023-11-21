<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('table_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('time')->useCurrent();
            $table->string('doer', 20);
            $table->string('user_id');
            $table->string('ip_address')->default('');
            $table->string('via')->default('');
            $table->string('guard', 10);
            $table->string('logable_id');
            $table->string('logable_type');
            $table->string('action', 20);
            $table->integer('batch')->default(1);
            $table->integer('transaction_batch')->default(0);
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_logs');
    }
};
