<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id', 15)->primary()->comment('prefix:USR');
            $table->string('first_name', 100)->default('');
            $table->string('last_name', 100)->default('');
            $table->string('email', 100)->unique()->comment('username');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 15)->default('');
            $table->string('password')->default('');
            $table->unsignedBigInteger('role_id');
            $table->char('is_active', 1)->default('1');
            $table->text('comment')->nullable();
            $table->smallInteger('attempts')->default(0);
            $table->rememberToken();
            $table->uuid();
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_by', 15);
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('updated_by', 15);
            $table->softDeletes();
            $table->string('deleted_by')->nullable();
            $table->string('restored_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
