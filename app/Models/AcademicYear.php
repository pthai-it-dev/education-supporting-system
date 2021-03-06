<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AcademicYear extends Model
{
    use HasFactory, Filterable;

    public const TABLE = 'academic_years';
    public const TABLE_AS = 'academic_years as ays';

    protected $table = 'academic_years';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'id_training_type',
    ];

    private array $filterable = [];

    private array $sortable = [
        'id',
    ];

    public function classes () : HasMany
    {
        return $this->hasMany(Class_::class, 'id_academic_year', 'id');
    }

    public function trainingType () : BelongsTo
    {
        return $this->belongsTo(TrainingType::class, 'id_training_type', 'id');
    }

    public function majors () : BelongsToMany
    {
        return $this->belongsToMany(Major::class, 'academic_year_major', 'id_academic_year',
                                    'id_major')->withPivot(['id_curriculum']);
    }
}
