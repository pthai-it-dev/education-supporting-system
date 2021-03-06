<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UpdateExamSchedulePatchRequest;
use App\Services\Contracts\ExamScheduleServiceContract;
use App\Http\Requests\CreateExamScheduleTeacherPostRequest;

class ExamScheduleController extends Controller
{
    private ExamScheduleServiceContract $examScheduleService;

    /**
     * @param ExamScheduleServiceContract $examScheduleService
     */
    public function __construct (ExamScheduleServiceContract $examScheduleService)
    {
        $this->examScheduleService = $examScheduleService;
    }

    public function readManyByIdDepartment (Request $request, string $idDepartment)
    {
        Gate::authorize('get-department-exam-schedule');
        return $this->examScheduleService->readManyByIdDepartment($idDepartment, $request->all());
    }

    public function readManyByIdTeacher (Request $request, string $idTeacher)
    {
        Gate::authorize('get-teacher-exam-schedule');
        return $this->examScheduleService->readManyByIdTeacher($idTeacher, $request->all());
    }

    public function readManyByIdStudent (Request $request, string $idStudent)
    {
        return $this->examScheduleService->readManyByIdStudent($idStudent, $request->all());
    }

    public function update (Request $request)
    {
        Gate::authorize('update-exam-schedule');
        $this->examScheduleService->update($request->all());
    }

    public function updateV1 (UpdateExamSchedulePatchRequest $request, string $idExamSchedule)
    {
        $this->examScheduleService->updateV1($idExamSchedule, $request->all());
    }

    public function createExamScheduleTeacher (CreateExamScheduleTeacherPostRequest $request, string $idExamSchedule)
    {
        $this->examScheduleService->createExamScheduleTeacher($idExamSchedule, $request->validated());
    }
}
