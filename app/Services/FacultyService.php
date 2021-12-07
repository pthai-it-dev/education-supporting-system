<?php

namespace App\Services;

use App\Repositories\Contracts\FacultyRepositoryContract;
use App\Helpers\GData;

class FacultyService implements Contracts\FacultyServiceContract
{
    private FacultyRepositoryContract $facultyDepository;

    /**
     * @param FacultyRepositoryContract $facultyDepository
     */
    public function __construct (FacultyRepositoryContract $facultyDepository)
    {
        $this->facultyDepository = $facultyDepository;
    }

    public function getIDFaculties ()
    {
        return $this->facultyDepository->getIDFaculties(GData::$id_faculties_not_query);
    }
}