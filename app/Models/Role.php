<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    public const TABLE = 'roles';
    public const TABLE_AS = 'roles as rls';

    protected $table = 'roles';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];

    public function permissions () : BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'id_role',
                                    'id_permission')
                    ->where('is_granted', '=', 1);
    }

    public function accounts () : HasMany
    {
        return $this->hasMany(Account::class, 'id_role', 'id');
    }
}
