<?php

namespace App\Traits;

trait HasSlug
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $slug = preg_replace('/[ ,]+/', '-', trim($query->name));
            // bin2hex(random_bytes(2))
            $query->slug = self::uniqueAssert($slug);
        });

        static::updating(function ($query) {
            // update slug -> only if there's a new name in the request
            if ($query->name != $query->original['name']) {
                $slug = preg_replace('/[ ,]+/', '-', trim($query->name));
                $query->slug = self::uniqueAssert($slug);
            }
        });
    }
    private static function uniqueAssert($slug, $counter = 1)
    {
        $newSlug = parent::where('slug', $slug)->exists() ? $slug . '-' . $counter : $slug;
        if (parent::where('slug', $newSlug)->exists()) {
            // if it still exists regenerate
            $counter += 1;
            return self::uniqueAssert($slug, $counter);
        } else {
            return $newSlug;
        }
    }
}
