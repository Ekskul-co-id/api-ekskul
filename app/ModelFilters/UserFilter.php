<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function keyword($value)
    {
        return $this->where(function ($q) use ($value) {
            return $this->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
        });
    }
}
