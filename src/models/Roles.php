<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/DB.php");


class Roles 
{

    public function findAll()
    {
        $pdo = new DB();

        $query = "SELECT * FROM roles;";

        $stmnt = $pdo->connect()->query($query);

        $data = [];

        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function findAllWithUsers()
    {
        $pdo = new DB();
        $query = "
        SELECT user.id, email, roles.description
        FROM user
	        INNER JOIN roles
    	        ON user.role_id = roles.id
        ORDER BY user.id;
        ";

        $stmnt = $pdo->connect()->query($query);

        $data = [];

        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

}

?>