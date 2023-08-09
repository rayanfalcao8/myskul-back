<?php

namespace Modules\Authorization\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    public function isAdmin(): bool
    {
        return $this->name === 'admin';
    }

    protected static function newFactory()
    {
        // return \Modules\Authorization\Database\factories\RoleFactory::new();
    }
}
