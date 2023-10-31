<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Alumnos.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Roles.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Clases.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/Instructor.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/models/User.php");


class LoginController
{
    public function index()
    {
        include $_SERVER["DOCUMENT_ROOT"] . "/src/views/login.php";
    }

    public function verifyLoggin()
    {
        $userModel = new User();
        $userEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        // $userEmail = checkEmail($userEmail);
        $userPassword = filter_input(INPUT_POST, 'pssword');

        if (empty($userEmail) || empty($userPassword)) {
            $message = '<p class="notice">Please provide a valid email address and password.</p>';
            include $_SERVER['DOCUMENT_ROOT'] . '/src/views/login.php'; 
            exit;
        }

        $userData = $userModel->getUserByEmail($userEmail);

        if (!$userData) {
            $message = '<p class="notice">Please check your email address and password and try again.</p>';
            include $_SERVER['DOCUMENT_ROOT'] . '/src/views/login.php'; 
            exit;
        }


        $hashCheck = password_verify($userPassword, $userData['password']);

        if (!$hashCheck) {

            $message = '<p class="notice">Paso Please check your email and password and try again.</p>';
            include $_SERVER['DOCUMENT_ROOT'] . '/src/views/login.php'; 
            exit;
          }
        array_pop($userData);


        $role = $userData["role_id"];


        switch ($role) {
            case 1:
                $_SESSION["role"] = "admin";
                break;

            case 2:
                $_SESSION["role"] = "instructor";
                $model = new Instructor();
                $id = $userData["id"];
                $instructor = $model->findOneByUserId($id);
                $_SESSION["instructor_id"] = $instructor["id"];
                break;

            case 3:
                $_SESSION["role"] = "student";
                $model = new Alumnos();
                $id = $userData["id"];
                $student = $model->findOne($id);
                $_SESSION["student_id"] = $student["student_id"];
                break;
        }

        $_SESSION['loggedin'] = TRUE;
        $_SESSION['userData'] = $userData;

        include $_SERVER['DOCUMENT_ROOT'] . '/index.php'; 
        exit;
    }

    public function route($action)
    {
        switch ($action) {
            case 'login':
                $this->verifyLoggin();
                break;

            default:
                $this->index();
                break;
        }
    }
}
