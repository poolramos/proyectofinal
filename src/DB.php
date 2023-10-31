<?php 

$file = $_SERVER["DOCUMENT_ROOT"] . "/.env";

if (file_exists($file)) {
    $variables = parse_ini_file($file);
    $_ENV = $variables;
} else {
    throw new Exception("No .env file found");
}

class DB
{
    private $pdo;

    public function __construct()
    {
        try {
            $host = $_ENV["DB_HOST"];
            $dbname = $_ENV["DB_DATABASE"];
            $port = $_ENV["DB_PORT"];
            $username = $_ENV["DB_USERNAME"];
            $password = $_ENV["DB_PASSWORD"];

            $attributes = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
            $this->pdo = new PDO($dsn, $username, $password, $attributes);


        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function connect()
    {
        return $this->pdo;
    }

    public function disconnect()
    {
        $this->pdo = null;
    }
}
?>
