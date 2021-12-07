<?php

namespace App\Repositories\Contracts;

interface StudentRepositoryContract
{
    public function insertMultiple ($data);

    public function getIDStudents1 ($classes);

    public function getIDStudents2 ($id_module_classes);

    public function getIDStudents3 ($id_accounts);

    public function getIDAccounts ($id_students);

    public function updateMultiple1 ($id_students);

    public function updateMultiple2 ($id_students, $column_name);

    public function getIDStudentsMissing ($id_students);
}