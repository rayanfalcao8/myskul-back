<?php

namespace Modules\Quiz\Filters;

use Modules\Core\Filters\AbstractFilters;
use Modules\Quiz\Filters\NameFilter;

class QuizFilters extends AbstractFilters
{
    public array $filters = [
        'name' => NameFilter::class,
        'level_id' => LevelIDFilter::class,
        'speciality_id' => SpecialityIDFilter::class,
    ];
}
