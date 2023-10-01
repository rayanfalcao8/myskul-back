<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Modules\Quiz\Filters\QuizFilters;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'displayText',
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\CategoryFactory::new();
    }

    public function scopeFilter(Builder $query, Request $request, array $filters = []): Builder
    {
        return (new QuizFilters($request))->add($filters)->filter($query);
    }
}
