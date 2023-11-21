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
        if (!Schema::hasTable('logs_details')) {
            Schema::create('logs_details', function (Blueprint $table) {
                $table->integer('id', true);
                $table->string('log_id', 12);
                $table->string('content', 255);
                $table->string('level', 10)->default('info');
                $table->string('relational_model', 100)->default('');
                $table->string('relational_id', 20)->default('');
                $table->foreign('log_id')->references('log_id')->on('logs');
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
        Schema::dropIfExists('logs_details');
    }
};
