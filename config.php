<?php
class db_connect {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $name = "db_lms";
    private $charset = "utf8mb4";
    public $conn;
    public $error;

    public function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->name};charset={$this->charset}";

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn; // Return the connection on success
        } catch (PDOException $e) {
            $this->error = "Fatal Error: Can't connect to database - " . $e->getMessage();
            return false;
       }
    }
}
?>