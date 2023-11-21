<?php

namespace Database\Migrations;

class CommonStructures
{
    public static function structure($table, $onlyCreatedPart = false): void
    {
        $table->uuid()->unique();
        $table->timestamp('created_at')->useCurrent();
        $table->string('created_by', 12);
        $table->foreign('created_by')->references('user_id')->on('users');
        if (!$onlyCreatedPart) {
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('updated_by', 12);
            $table->foreign('updated_by')->references('user_id')->on('users');
        }
    }
}
