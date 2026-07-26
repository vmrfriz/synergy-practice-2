<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Hideable
{
    public static function bootHideable(): void
    {
        static::addGlobalScope('hideable', function (Builder $builder) {
            $builder->where('hidden', false);
        });
    }

    public function scopeWithHidden(Builder $query, bool $withHidden = true): Builder
    {
        if ($withHidden) {
            return $query->withoutGlobalScope('hideable');
        }

        return $query;
    }

    public function scopeOnlyHidden(Builder $query): Builder
    {
        return $query->withoutGlobalScope('hideable')->where('hidden', true);
    }
}
