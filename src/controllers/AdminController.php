<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Alumnos.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Roles.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Clases.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Instructor.php");


class AdminController
{
    public function index()
    {
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/dashboard.php";
    }

    //Students
    public function create($request)
    {

        $email = $request["email"];
        $this->verifyEmail($email);

        $studentModel = new Alumnos();
        $studentModel->create($request);
    }

    public function verifyEmail($email)
    {
        if (isset($email)) {
            $userModel = new User();
            $emailExist = $userModel->checkExistingEmail($email);
            if ($emailExist) {
                $message  = '<p class="text-center text-red-600">El email ya existe</p>';
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/create-student.php";
                exit;
            }
        }
    }

    public function update($request)
    {   
        $model = new Alumnos();
        return $model->update($request);
    }

    public function findAll()
    {
        $model = new Alumnos();
        return $model->findAll();
    }

    public function findOne($id)
    {
        $model = new Alumnos();
        return $model->findOne($id);
    }

    public function delete($id)
    {
        $model = new Alumnos();
        $delete = $model->delete($id);
        if ($delete) {
            $this->showStudentTable();
        } else {
            header('Location: /index.php');
        }
    }

    public function showStudentTable()
    {
        $students = $this->findAll();
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/table-student.php";
    }

    //Roles 

    public function showUserTableWithRoles()
    {
        $model =    new Roles();
        $users = $model->findAllWithUsers();
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/permisos/table-roles.php";
    }


    //CLases
    public function showClasesTable()
    {
        $model = new Clases();
        $clases = $model->findAll();
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/clases/table-clases.php";
    }

    public function createClase($request)
    {
        $claseModel = new Clases();

        if (isset($request["instructor_id"]) && $request["instructor_id"] == 0) {
            $claseModel->createWithInstructor($request);
            $this->showClasesTable();
        }

        $claseModel->create($request);
        $this->showClasesTable();
    }


    public function deleteClase($clase_id)
    {
        $claseModel = new Clases();
        $claseModel->delete($clase_id);
        $this->showClasesTable();
    }


    public function route($action)
    {
        switch ($action) {
                //Students
            case 'create-student':
                $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $user = $this->create($_POST);
                $this->showStudentTable();
                break;

            case 'create-student-view':
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/create-student.php";
                break;

            case 'edit-student-view':
                $id = $_GET["user_id"];
                $student = $this->findOne($id);
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/edit-student.php";
                break;

            case 'edit-student':
                $user = $this->update($_POST);

                if ($user == 1) {
                    $this->showStudentTable();
                    exit;
                } else {
                    include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/edit-student.php";
                }
                break;


            case 'delete-student':
                $id = $_POST["user_id"];
                $this->delete($id);
                break;

            case 'update':
                $this->update($_POST);
                break;

                //Cambiar nombre del endpoint
            case 'user-table':
                $this->showStudentTable();
                break;


                //Roles
            case 'table-roles':
                $this->showUserTableWithRoles();
                break;

            case 'edit-user-role':
                $id = $_GET["user_id"];
                $alumnosModel = new Alumnos();
                $user = $alumnosModel->findOneWithRole($id);

                $rolesModel = new Roles();
                $roles = $rolesModel->findAll();

                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/permisos/edit-user-role.php";
                break;

            case 'update-rol':
                $id = $_POST["user_id"];
                $role_id = $_POST["role"];
                $alumnosModel = new Alumnos();
                $alumnosModel->updateRole($id, $role_id);
                $this->showUserTableWithRoles();
                break;


            case 'clases-table':
                $clases = $this->showClasesTable();
                break;

            case 'create-clase-view':
                $instructorModel = new Instructor();
                $instructors = $instructorModel->findAll();
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/clases/create-clase.php";
                break;

            case 'create-clase':
                $this->createClase($_POST);

            case 'delete-clase':
                $this->deleteClase($_POST["clase_id"]);
                break;

            case 'edit-clase-view':
                $id = $_GET["clase_id"];
                $claseModel = new Clases();
                $clase = $claseModel->findOne($id);

                $instructorModel = new Instructor();
                $instructors = $instructorModel->findAll();
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/clases/edit-clase.php";
                break;

            case 'edit-clase':
                $claseModel = new Clases();
                $claseModel->update($_POST);
                $this->showClasesTable();
                break;


                //Instructors
            case 'instructor-table':
                $instructorModel = new Instructor();
                $instructors = $instructorModel->findAllWithUser();
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/instructors/table-instructors.php";
                break;

            case 'create-instructor-view':
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/instructors/create-instructor.php";
                break;

            case 'create-instructor':
                $instructorModel = new Instructor();
                $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $instructorModel->create($_POST);
                $email = $_POST["email"];
                $this->verifyEmail($email);
                $instructors = $instructorModel->findAllWithUser();
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/instructors/table-instructors.php";
                break;

            case 'edit-instructor-view':
                $id = $_GET["user_id"];
                $instructorModel = new Instructor();
                $instructor = $instructorModel->findOne($id);
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/instructors/edit-instructor.php";
                break;

            case 'edit-instructor':
                $instructorModel = new Instructor();
                $instructorModel->update($_POST);
                $instructors = $instructorModel->findAllWithUser();
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/instructors/table-instructors.php";
                break;


            case 'edit-instructor-clases-view':
                $instructorId = $_GET["instructor_id"];
                $clasesModel = new Clases();
                $clases = $clasesModel->findClasesWithInstructorId();
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/instructors/edit-instructor-clases.php";
                break;

            case 'edit-instructor-clases':

                if (isset($_POST["clases"])) {
                    $clases = $_POST["clases"];
                    $instructorId = $_POST["instructor_id"];
                    $instructorModel = new Instructor();
                    $instructorModel->updateClases($instructorId, $clases);
                } else {
                    $instructorId = $_POST["instructor_id"];
                    $instructorModel = new Instructor();
                    $instructorModel->deleteClases($instructorId);
                }

                $instructorModel = new Instructor();
                $instructors = $instructorModel->findAllWithUser();
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/instructors/table-instructors.php";

                break;

            case 'delete-instructor':
                $id = $_POST["user_id"];
                $instructorModel = new Instructor();
                $instructor = $instructorModel->findOne($id);
                $delete = $instructorModel->delete($instructor["user_id"]);
                $instructors = $instructorModel->findAllWithUser();
                include $_SERVER["DOCUMENT_ROOT"] . "/src/views/admin/instructors/table-instructors.php";
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
