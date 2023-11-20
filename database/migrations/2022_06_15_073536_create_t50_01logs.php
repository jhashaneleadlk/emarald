<?php

use Database\Migrations\CommonStructures;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('logs')) {
            Schema::create('logs', function (Blueprint $table) {
                $table->string('log_id', 12)->primary();
                $table->string('log_name', 100)->default('');
                $table->string('log_signature', 200)->default('');
                $table->string('log_parameters', 100)->default('');
                CommonStructures::structure($table);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
