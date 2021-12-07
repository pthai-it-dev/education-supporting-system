<?php

namespace App\Http\Controllers;

use App\Services\Contracts\ClassServiceContract;
use Illuminate\Http\Request;

class FacultyClassController extends Controller
{
    private ClassServiceContract $facultyClassService;

    /**
     * @param ClassServiceContract $facultyClassService
     */
    public function __construct (ClassServiceContract $facultyClassService)
    {
        $this->facultyClassService = $facultyClassService;
    }

    public function getFacultyClasses (Request $request)
    {
        $data = $this->facultyClassService->getFacultyClasses($request->id_academic_years,
                                                              $request->id_faculties);
        return response($data)->header('Content-Type', 'application/data');
    }
}