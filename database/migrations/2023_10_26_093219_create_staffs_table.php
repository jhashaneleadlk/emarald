<?php

use Database\Migrations\CommonStructures;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->string('staff_id', 15)->primary()->comment('prefix:STAFF');
            $table->string('name');
            $table->string('contact_person');
            $table->string('email')->unique();
            $table->string('phone')->default('');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default('');
            $table->unsignedBigInteger('role_id')->default(4);
            $table->boolean('is_active')->default(true);
            $table->text('comment')->nullable();
            $table->smallInteger('attempts')->default(0);
            $table->rememberToken();
            CommonStructures::structure($table);
            $table->softDeletes();
            $table->string('deleted_by')->nullable();
            $table->string('restored_by')->nullable();
            $table->foreign('deleted_by')->references('user_id')->on('users');
            $table->foreign('restored_by')->references('user_id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};
