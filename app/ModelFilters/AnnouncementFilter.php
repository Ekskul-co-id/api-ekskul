<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class AnnouncementFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    // filter by keyword
    public function keyword($value)
    {
        return $this->where(function ($q) use ($value) {
            return $q->where('message', 'like', "%{$value}%")
                ->orWhere('title', 'like', "%{$value}%");
        });
    }
}
