<?php
class db_connect {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $name = "db_lms";
    private $charset = "utf8mb4";
    public $conn; 
    public $error; 

    public function __construct() {
        $this->connect(); // Automatically connect on class initialization
    }

    public function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->name};charset={$this->charset}";

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn; // Return the connection on success
        } catch (PDOException $e) {
            $this->error = "Fatal Error: Can't connect to database - " . $e->getMessage();
            return false;
        }
    }
}
?>