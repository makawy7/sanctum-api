<?php

namespace App\Traits;

trait HasSlug
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->slug = str_replace(' ', '-', $query->name);
        });
    }
}
