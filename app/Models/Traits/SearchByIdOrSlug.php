<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method findByIdOrSlug($value)
 */
trait SearchByIdOrSlug
{
    /**
     * @param $value
     * @param null $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->findByIdOrSlug($value)->first();
    }

    /**
     * @param Builder $query
     * @param string $value
     * @return Builder
     */
    public function scopeFindByIdOrSlug(Builder $query, string $value): Builder
    {
        return $query->where('slug', $value)->orWhere('id', $value);
    }
}
