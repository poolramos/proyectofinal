<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/DB.php");



class Instructor
{
    public function findAll()
    {
        $pdo = new DB();

        $query = "
        SELECT instructor.id as id, user.id as user_id, concat(firstname, ' ', lastname) as fullname  
        FROM instructor
            INNER JOIN user
                ON user.id = instructor.user_id;
        ";

        $stmnt = $pdo->connect()->query($query);

        $data = [];

        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function findAllWithUser()
    {
        $pdo = new DB();

        $query = "
        SELECT instructor.id, concat(firstname, ' ', lastname) as fullname, email, address, DATE_FORMAT(birthday, '%Y-%m-%d') as birthday, count(clases.instructor_id) as count
        FROM instructor
        INNER JOIN user
                ON user.id = instructor.user_id
	    LEFT JOIN clases
    	    ON instructor.id = clases.instructor_id
        GROUP BY instructor.id, fullname
        ORDER BY instructor.id;
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
        SELECT instructor.id as id, user.id as user_id,  firstname, lastname, email, address, DATE_FORMAT(birthday, '%Y-%m-%d') as birthday  FROM user
        INNER JOIN instructor
            ON user.id = instructor.user_id
         WHERE instructor.id = :id;
        ";

        $stmnt = $conn->connect()->prepare($query);
        $stmnt->bindParam(":id", $id);
        $stmnt->execute();
        $student = $stmnt->fetch(PDO::FETCH_ASSOC);
        return $student;
    }

    public function findOneByUserId($id)
    {
        $conn = new DB();
        $query = "
        SELECT instructor.id as id, user.id as user_id,  firstname, lastname, email, address, DATE_FORMAT(birthday, '%Y-%m-%d') as birthday  FROM user
        INNER JOIN instructor
            ON user.id = instructor.user_id
         WHERE user.id = :id;
        ";

        $stmnt = $conn->connect()->prepare($query);
        $stmnt->bindParam(":id", $id);
        $stmnt->execute();
        $student = $stmnt->fetch(PDO::FETCH_ASSOC);
        return $student;
    }

    public function create($request)
    {
        extract($request);
        $role_id = 2;

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

        $user_stmnt = "INSERT INTO instructor (user_id) VALUES (:user_id)";
        $user_stmnt = $conn->connect()->prepare($user_stmnt);
        $user_stmnt->bindParam(":user_id", $user_id);
        $user_stmnt->execute();
        $rowsChanged = $user_stmnt->rowCount();
        $conn->connect()->commit();


        $conn->disconnect();

        return 1;
    }


    public function countClases()
    {
        $query = "
        SELECT instructor.id, count(clases.instructor_id) as count
        FROM instructor
	    LEFT JOIN clases
    	    ON instructor.id = clases.instructor_id
        GROUP BY instructor.id
        ORDER BY instructor.id;
        ";

        $pdo = new DB();
        $stmnt = $pdo->connect()->query($query);

        $data = [];

        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function updateClases($instructorId, $clases)
    {
        $query = "UPDATE clases SET instructor_id = NULL WHERE instructor_id = :instructor_id";
        $pdo = new DB();
        $stmnt = $pdo->connect()->prepare($query);
        $stmnt->bindParam(":instructor_id", $instructorId);
        $stmnt->execute();

        foreach ($clases as $clase) {
            // $query = "INSERT INTO clases (instructor_id) VALUES (:instructor_id) WHERE clase_id = :clase_id";
            $query = "UPDATE clases SET instructor_id = :instructor_id WHERE id = :clase_id";
            $pdo = new DB();
            $stmnt = $pdo->connect()->prepare($query);
            $stmnt->bindParam(":instructor_id", $instructorId);
            $stmnt->bindParam(":clase_id", $clase);
            $stmnt->execute();
        }

        return 1;
    }

    public function deleteClases($instructorId)
    {
        $query = "UPDATE clases SET instructor_id = NULL WHERE instructor_id = :instructor_id";
        $pdo = new DB();
        $stmnt = $pdo->connect()->prepare($query);
        $stmnt->bindParam(":instructor_id", $instructorId);
        $stmnt->execute();
    }

    public function update($request)
    {
        $userId = $request["user_id"];
        $firstname = $request["firstname"];
        $lastname = $request["lastname"];
        $address = $request["address"];
        $birthday = $request["birthday"];
        $email = $request["email"];

        $conn = new DB();

        $query = "UPDATE user SET firstname = :firstname, lastname = :lastname, address = :address,  birthday = :birthday, email = :email  WHERE id = :user_id;";
        $stmnt = $conn->connect()->prepare($query);

        $stmnt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmnt->bindParam(":firstname", $firstname, PDO::PARAM_STR);
        $stmnt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $stmnt->bindParam(":address", $address, PDO::PARAM_STR);
        $stmnt->bindParam(":birthday", $birthday);
        $stmnt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmnt->execute();
        $rowsChanged = $stmnt->rowCount();
        return 1;
    }


    public function delete($id)
    {

        $conn = new DB();
        $updateQuery = "UPDATE clases SET instructor_id = NULL WHERE instructor_id = :id";
        $stmnt = $conn->connect()->prepare($updateQuery);
        $stmnt->bindParam(":id", $id, PDO::PARAM_INT);
        $result = $stmnt->execute();

        $query = "DELETE FROM instructor WHERE user_id = :id";
        $stmnt = $conn->connect()->prepare($query);
        $stmnt->bindParam(":id", $id, PDO::PARAM_INT);
        $result = $stmnt->execute();


        $query = "DELETE FROM user WHERE id = :id";
        $stmnt = $conn->connect()->prepare($query);
        $stmnt->bindParam(":id", $id, PDO::PARAM_INT);
        $result = $stmnt->execute();
        $conn->disconnect();

        return 1;
    }
}

?>