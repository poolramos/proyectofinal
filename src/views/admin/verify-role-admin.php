<?php 
// Verifica si el usuario tiene el role_id 1 (Admin) para permitir el acceso.
if ($_SESSION['role'] !== 'admin') {
    // El usuario no tiene el rol de administrador, redirige o muestra un mensaje de error.
    header("Location: /index.php");
    // Puedes redirigir al usuario a otra página o mostrar un mensaje de error.
    // Por ejemplo:
    // header("Location: pagina_de_error.php");
    exit;
}
?>
