<?php

namespace App\Traits;

trait UUIDTrait
{
    /**
     * Boot Blamable Behaviour trait for a model.
     */
    public static function bootUUIDTrait(): void
    {
        static::observe(UUID::class);
    }
}
