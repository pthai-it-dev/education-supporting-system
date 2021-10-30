<?php

namespace App\Repositories;

use App\Models\SchoolYear;

class SchoolYearRepository implements Contracts\SchoolYearRepositoryContract
{
    public function insert ($data)
    {
        SchoolYear::create($data)->id;
    }

    public function getMultiple ()
    {
        return SchoolYear::orderBy('id', 'desc')->limit(14)->pluck('id', 'school_year')->toArray();
    }
}