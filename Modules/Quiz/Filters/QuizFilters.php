<?php

namespace Modules\Quiz\Filters\Filters;

use Modules\Core\Filters\AbstractFilters;
use Modules\Quiz\Filters\NameFilter;

class QuizFilters extends AbstractFilters
{
    public array $filters = [
        'name' => NameFilter::class
    ];
}
