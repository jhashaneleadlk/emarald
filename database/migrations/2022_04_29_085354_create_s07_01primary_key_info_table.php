<?php

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
        if (!Schema::hasTable('primary_key_info')) {
            Schema::create('primary_key_info', function (Blueprint $table) {
                $table->string('key', 12)->primary();
                $table->string('model', 50);
                $table->string('prefix', 150);
                $table->string('field', 50);
                $table->tinyinteger('numbof_chars');
                $table->char('pad_sym', 1);
                $table->string('last_prkey', 50);
                $table->uuid();
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
        Schema::dropIfExists('primary_key_info');
    }
};
