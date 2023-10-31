<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/DB.php");


class Alumnos
{
    public function create($request)
    {
        extract($request);
        $role_id = 3;

        $conn = new DB();
        $conn->connect()->beginTransaction();
        $stmnt = $conn->connect()->prepare("INSERT INTO user (firstname, lastname, email, password,  address, birthday, role_id) VALUES (:firstname, :lastname, :email, :password, :address, :birthday, :role_id)");

        $stmnt->bindParam(":firstname", $firstname);
        $stmnt->bindParam(":lastname", $lastname);
        $stmnt->bindParam(":address", $address);
        $stmnt->bindParam(":birthday", $birthday);
        $stmnt->bindParam(":role_id", $role_id);
        $stmnt->bindParam(":email", $email);
        $stmnt->bindParam(":password", $password);
        $stmnt->execute();

        $user_id = $conn->connect()->lastInsertId();

        $user_stmnt = "INSERT INTO student (dni, user_id) VALUES (:dni, :user_id)";
        $user_stmnt = $conn->connect()->prepare($user_stmnt);
        $user_stmnt->bindParam(":dni", $dni);
        $user_stmnt->bindParam(":user_id", $user_id);
        $user_stmnt->execute();
        $rowsChanged = $user_stmnt->rowCount();
        $conn->connect()->commit();


        $conn->disconnect();

        return 1;
    }

    public function findAll()
    {
        $pdo = new DB();

        $query = "  
        SELECT user.id, student.id as student_id, dni, email, concat(firstname, ' ', lastname) as name, address, DATE_FORMAT(birthday, '%Y-%m-%d') as birthday  
        FROM  user
	    INNER JOIN student
    	ON user.id = student.user_id;
        ";

        $stmnt = $pdo->connect()->query($query);

        $data = [];

        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function findOne($id)
    {
        $conn = new DB();
        $query = "
            SELECT user.id, student.id as student_id, dni, firstname, lastname, email, address, DATE_FORMAT(birthday, '%Y-%m-%d') as birthday  FROM `user` user
            INNER JOIN student
            ON user.id = student.user_id
            WHERE user.id = :id;
        ";

        $stmnt = $conn->connect()->prepare($query);
        $stmnt->bindParam(":id", $id);
        $stmnt->execute();
        $student = $stmnt->fetch(PDO::FETCH_ASSOC);
        return $student;
    }

    public function findOneWithRole($user_id)
    {
        $conn = new DB();
        $query = "
        SELECT user.id, user.email, description, roles.id as role_id
        FROM user
	        INNER JOIN roles
    	        ON user.role_id = roles.id
        WHERE user.id = :user_id;
        ";

        $stmnt = $conn->connect()->prepare($query);
        $stmnt->bindParam(":user_id", $user_id);
        $stmnt->execute();
        $user = $stmnt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }


    public function update($request)
    {
        $id = $request["id"];
        $firstname = $request["firstname"];
        $lastname = $request["lastname"];
        $address = $request["address"];
        $birthday = $request["birthday"];


        $conn = new DB();

        $query = "UPDATE user SET firstname = :firstname, lastname = :lastname, address = :address,  birthday = :birthday  WHERE id = :id;";
        $stmnt = $conn->connect()->prepare($query);

        $stmnt->bindParam(":id", $id);
        $stmnt->bindParam(":firstname", $firstname, PDO::PARAM_STR);
        $stmnt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $stmnt->bindParam(":address", $address, PDO::PARAM_STR);
        $stmnt->bindParam(":birthday", $birthday);
        $stmnt->execute();
        $rowsChanged = $stmnt->rowCount();
        $conn->disconnect();

        return 1;
    }

    public function delete($id)
    {


        $conn = new DB();
        $query = "DELETE FROM student WHERE user_id = :id";
        $stmnt = $conn->connect()->prepare($query);
        $stmnt->bindParam(":id", $id, PDO::PARAM_INT);
        $result = $stmnt->execute();


        $query = "DELETE FROM user WHERE id = :id";
        $stmnt = $conn->connect()->prepare($query);
        $stmnt->bindParam(":id", $id, PDO::PARAM_INT);
        $result = $stmnt->execute();
        $conn->disconnect();

        return $result;
    }

    public function updateRole($userId, $permisoId)
    {
        $conn = new DB();
        $query = "UPDATE user SET role_id = :role_id WHERE id = :id";
        $stmnt = $conn->connect()->prepare($query);
        $stmnt->bindParam(":id", $userId);
        $stmnt->bindParam(":role_id", $permisoId);
        $stmnt->execute();
        $permisos = $stmnt->fetchAll(PDO::FETCH_ASSOC);
        return $permisos;
    }


    public function findStudentsByInstructorId($id)
    {
        $query = "SELECT student.id as student_id, concat(firstname, ' ', lastname) as student_name, clases.name as class_name
                    FROM user
                        INNER JOIN student
                            ON student.user_id = user.id
                         INNER JOIN studet_clases
                             ON studet_clases.id_student = student.id
                         INNER JOIN clases
                             ON studet_clases.id_clase = clases.id
                         INNER JOIN instructor
                             ON instructor.id = clases.instructor_id
                         WHERE instructor.id = :id;";
        
        $pdo = new DB();
        $stmnt = $pdo->connect()->prepare($query);
        $stmnt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmnt->execute();

        $data = [];

        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function findStudentsByClassId($id)
    {
        $query = "SELECT student.id as student_id, concat(firstname, ' ', lastname) as student_name, clases.name as class_name
                    FROM user
                        INNER JOIN student
                            ON student.user_id = user.id
                         INNER JOIN studet_clases
                             ON studet_clases.id_student = student.id
                         INNER JOIN clases
                             ON studet_clases.id_clase = clases.id
                         WHERE clases.id = :id;";
                         
        $pdo = new DB();
        $stmnt = $pdo->connect()->prepare($query);
        $stmnt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmnt->execute();

        $data = [];

        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function deleteClassFromStudent($id_student, $id_clase)
    {
        $query = "DELETE FROM studet_clases WHERE id_student = :id_student AND id_clase = :id_clase;";

        $pdo = new DB();
        $stmnt = $pdo->connect()->prepare($query);
        $stmnt->bindParam(":id_student", $id_student, PDO::PARAM_INT);
        $stmnt->bindParam(":id_clase", $id_clase, PDO::PARAM_INT);
        $stmnt->execute();
        return 1;
    }


    public function addClasses($id_student, $id_clase)
    {
        $query = "INSERT INTO studet_clases (id_student, id_clase) VALUES (:id_student, :id_clase);";
        $pdo = new DB();
        $stmnt = $pdo->connect()->prepare($query);
        $stmnt->bindParam(":id_student", $id_student, PDO::PARAM_INT);
        $stmnt->bindParam(":id_clase", $id_clase, PDO::PARAM_INT);
        $stmnt->execute();
        return 1;
    }
}
