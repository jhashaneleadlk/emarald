<?php

namespace App\Traits;

trait WhoDidItTrait
{
    /**
     * Boot Blamable Behaviour trait for a model.
     */
    public static function bootWhoDidItTrait(): void
    {
        static::observe(WhoDidIt::class);
    }
}
