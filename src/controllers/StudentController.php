<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Alumnos.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Roles.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Clases.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Instructor.php");


class StudentController
{
    public function index()
    {
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/student/dashboard.php";
    }


    public function showStudentInformation($message = null)
    {
        $id = $_SESSION["userData"]["id"];
        $model = new Alumnos();
        $student = $model->findOne($id);
        $message;
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/student/edit-student.php";
    }

    public function updateStudent($request)
    {
        $model = new Alumnos();
        $model->update($request);
        $message = '<p class="text-center text-green-500">Instructor actualizado correctamente</p>';
        $this->showStudentInformation($message);
    }

    public function showClases()
    {
        $id = $_SESSION["student_id"];
        $model = new Clases();
        $studentClasses = $model->findClasesByStudentId($id);
        $classesNotRegistered = $model->findClasesNotRegisteredByStudentId($id);
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/student/student-class.php";
    }

    public function deleteClassFromStudent()
    {
        $studentId = $_GET["student_id"];
        $classId = $_GET["class_id"];
        $model = new Alumnos();
        $isDeleted = $model->deleteClassFromStudent($studentId, $classId);
        $this->showClases();
    }


    public function addCourse()
    {
        $studentId = $_SESSION["student_id"];
        $classId = $_GET["class_id"];
        $model = new Alumnos();
        $isAdded = $model->addClasses($studentId, $classId);
        $this->showClases();
    }

    public function route($action)
    {
        switch ($action) {

            case 'edit-student-view':
                $this->showStudentInformation();
                break;

            case 'edit-student':
                $this->updateStudent($_POST);
                break;

            case 'show-clases-table':
                $this->showClases();
                break;

            case 'delete-student-class':
                $this->deleteClassFromStudent();
                break;

            case 'add-student-class':
                $this->addCourse();
                break;

            case 'logout':
                session_destroy();
                header('Location: /index.php');
                break;

            default:
                $this->index();
                break;
        }
    }
}
