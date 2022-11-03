<?php

namespace App\Models\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait Sortable
{
    /**
     * @param Builder $query
     * @param string|array|null $sort_list
     * @return Builder
     * @throws Exception
     */
    public function scopeSorting(Builder $query, string|array|null $sort_list): Builder
    {
        if (empty($sort_list)) {
            return $query;
        }

        if (is_string($sort_list)) {
            $sort_list = [$sort_list];
        }

        foreach ($sort_list as $sort) {
            if (Str::startsWith($sort, '-')) {
                $sort = Str::after($sort, '-');
                if (empty($sort)) {
                    return throw new Exception('Неверный параметр сортировки');
                }
                $query->orderByDesc($sort);
            } else {
                $query->orderBy($sort);
            }
        }
        return $query;
    }
}
