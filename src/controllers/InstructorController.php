<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Alumnos.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Roles.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Clases.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Instructor.php");

class InstructorControlller
{
    public function index()
    {
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/instructor/dashboard.php";
    }

    public function showStudentTable($id)
    {
        $model = new Alumnos();
        $students = $model->findStudentsByInstructorId($id);
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/instructor/student-table.php";
    }

    public function showClasesTable($id)
    {
        $model = new Clases();
        $clases = $model->findClasesByInstructorId($id);
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/instructor/clases-table.php";
    }

    public function showStudentsByClass()
    {
        $id = $_GET["class_id"];
        $model = new Alumnos();
        $className = $_GET["class_name"];
        $students = $model->findStudentsByClassId($id);
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/instructor/student-table-custom.php";
    }

    public function showInstructorInformation($message = null)
    {
        $id = $_SESSION["instructor_id"];
        $model = new Instructor();
        $instructor = $model->findOne($id);
        $message;
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/instructor/edit-instructor.php";
    }

    public function updateInstructor()
    {
        $id = $_SESSION["userData"]["id"];
        $model = new Instructor();
        $_POST["user_id"] = $id;

        if ($_POST["email"]) {
            $this->verifyEmail($_POST["email"]);
        }

        $instructorCreated = $model->update($_POST);
        $message = '<p class="text-center text-green-500">Instructor actualizado correctamente</p>';
        $this->showInstructorInformation($message);
    }

    public function verifyEmail($email)
    {
        if (isset($email)) {
            $userModel = new User();
            $emailExist = $userModel->checkExistingEmail($email);
            if ($emailExist) {
                $message  = '<p class="text-center text-red-600">El email ya existe</p>';
                $this->showInstructorInformation($message);
                exit;
            }
        }
    }

    public function route($action)
    {
        switch ($action) {
            case 'show-student-table':
                $id = $_SESSION["instructor_id"];
                $this->showStudentTable($id);
                break;

            case 'show-clases-table':
                $id = $_SESSION["instructor_id"];
                $this->showClasesTable($id);
                break;

            case 'show-student-class':
                $this->showStudentsByClass();
                break;

            case 'edit-instructor-view':
                $this->showInstructorInformation();
                break;

            case 'edit-instructor':
                $this->updateInstructor();
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
