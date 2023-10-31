
<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/DB.php");


class User
{
    public function getUserByEmail($userEmail)
    {
        $db = new DB();
        $sql = 'SELECT id, firstname, lastname, email, role_id, password FROM user WHERE email = :userEmail';
        $stmt = $db->connect()->prepare($sql);
        $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
        $stmt->execute();
        $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $clientData;
    }

    function checkExistingEmail($userEmail)
    {
        $db = new DB();
        $sql = 'SELECT email FROM user WHERE email = :userEmail';
        $stmt = $db->connect()->prepare($sql);
        $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
        $stmt->execute();
        $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();

        if (empty($matchEmail)) {
            return 0;
        } else {
            return 1;
        }
    }
}


?>


