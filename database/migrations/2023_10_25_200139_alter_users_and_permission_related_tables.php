<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->change()->after('franchise_id');
            $table->uuid()->after('is_active');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->tinyInteger('franchise_type')->nullable()->after('guard_name');
            $table->uuid()->after('franchise_type');
        });

        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->string('model_id')->change();
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->string('model_id')->change();
        });

        Artisan::call('db:seed', ['--class' => 'Seeder_20231025_DR_RoleSetWithParticularUsers']);


        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
            $table->boolean('is_active')->default(true)->change();
        });
    }

    public function down(): void
    {
        // cannot roll back
    }
};
