<?php 

if(!isset($_SESSION)) session_start();

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

$controller = null;

if (isset($_SESSION["role"])) {
    $controller = $_SESSION["role"];
}

require_once($_SERVER["DOCUMENT_ROOT"] . "/src/controllers/AdminController.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/controllers/InstructorController.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/controllers/StudentController.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/controllers/LoginController.php");

switch ($controller) {
    case 'admin':
        if(isset($action)){
            $adminController = new AdminController();
            $adminController->route($action);
        } else {
            $adminController = new AdminController();
            $adminController->index();
        }
        break;
    case 'instructor':
        if(isset($action)){
            $instructorController = new InstructorControlller();
            $instructorController->route($action);
        } 
        
        else {
            $instructorController = new InstructorControlller();
            $instructorController->index();
        }
        break;
    case 'student':
        if(isset($action)){
            $studentController = new StudentController();
            $studentController->route($action);
        } 
        
        else {
            $studentController = new StudentController();
            $studentController->index();
        }
        break;

    default:
    if(isset($action)){
        $loginController = new loginController();
        $loginController->route($action);
    } 
    else {
        $loginController = new loginController();
        $loginController->index();
    }   
        break;
}
?>
