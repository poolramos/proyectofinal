<?php 

require_once($_SERVER["DOCUMENT_ROOT"] . "/src/DB.php");

class Clases
{
    public function findAll()
    {
        $pdo = new DB();

        $query = "
        SELECT clases.id, name, concat(user.firstname, ' ', user.lastname) as maestro
        FROM clases
	        LEFT JOIN instructor
    	        ON clases.instructor_id = instructor.id
            LEFT JOIN user
    	        ON user.id = instructor.user_id;
        ";

        $stmnt = $pdo->connect()->query($query);

        $data = [];

        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function create($request)
    {
        $pdo = new DB();
        $name = $request["name"];
        $query = "INSERT INTO clases (name) VALUES (:name);";
        
        $stmnt = $pdo->connect()->prepare($query);
        $stmnt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmnt->execute();
        return 1;
    }

    public function createWithInstructor($request)
    {
        $pdo = new DB();
        $name = $request["name"];
        $instructor_id = $request["instructor_id"];
        $query = "INSERT INTO clases (name, instructor_id) VALUES (:name, :instructor_id);";
        
        $stmnt = $pdo->connect()->prepare($query);
        $stmnt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmnt->bindParam(":instructor_id", $instructor_id, PDO::PARAM_INT);
        $stmnt->execute();
        return 1;
    }



    public function delete($clase_id)
    {
        $conn = new DB();

        $query = "DELETE FROM clases WHERE id = :id";
        $stmnt = $conn->connect()->prepare($query);
        $stmnt->bindParam(":id", $clase_id, PDO::PARAM_INT);
        $result = $stmnt->execute();
        $conn->disconnect();

        return $result;
    }

    public function findOne($id)
    {
        $conn = new DB();

        $query = "SELECT * FROM clases WHERE id = :id";
        $stmnt = $conn->connect()->prepare($query);
        $stmnt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmnt->execute();
        $result = $stmnt->fetch(PDO::FETCH_ASSOC);
        $conn->disconnect();

        return $result;
    }

    public function update($request)
    {
        $id = $request["id"];
        $name = $request["name"];
        $instructor_id = $request["instructor_id"];

        $pdo = new DB();
        $query = "UPDATE clases SET name = :name, instructor_id = :instructor_id  WHERE id = :id;";
        $stmnt = $pdo->connect()->prepare($query);

        $stmnt = $pdo->connect()->prepare($query);
        $stmnt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmnt->bindParam(":instructor_id", $instructor_id, PDO::PARAM_INT);
        $stmnt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmnt->execute();
        // $rowsChanged = 
        $pdo->disconnect();

        return 1;
    }

    public function findClasesWithInstructorId()
    {
        $query = "
        SELECT clases.name as clase_name, clases.id as clase_id, instructor_id
        FROM clases;
        ";
        $pdo = new DB();
        $stmnt = $pdo->connect()->query($query);

        $data = [];

        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function findClasesByInstructorId($id)
    {
        $query = "
        SELECT clases.name as class_name, clases.id as class_id, instructor_id
        FROM clases
        WHERE instructor_id = :id;
        ";
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

    public function findClasesByStudentId($id)
    {
        $query = "SELECT clases.id as class_id, student.id as student_id, clases.name as class_name
                FROM user
                    INNER JOIN student
                        ON student.user_id = user.id
                     INNER JOIN studet_clases
                         ON studet_clases.id_student = student.id
                     INNER JOIN clases
                         ON studet_clases.id_clase = clases.id
                     WHERE student.id = :id;";
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

    public function findClasesNotRegisteredByStudentId($id)
    {
        $query = "SELECT clases.id as class_id, clases.name as class_name
                FROM clases
                WHERE clases.id NOT IN (
                    SELECT studet_clases.id_clase
                    FROM student
                    INNER JOIN studet_clases ON studet_clases.id_student = student.id
                    WHERE student.id = :id
        );";
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

}
?>
