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

        Schema::create('seeders_manage', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('seeder_class_name', 100)->default('')->unique();
        });

        Artisan::call('db:seed', ['--class' => 'Seeder_20220822_DR_UsersDefault']);

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_by')->references('user_id')->on('users');
            $table->foreign('updated_by')->references('user_id')->on('users');
            $table->foreign('deleted_by')->references('user_id')->on('users');
            $table->foreign('restored_by')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seeders_manage');
    }
};
