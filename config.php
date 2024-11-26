<?php
class db_connect {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $name = "db_lms";
    public $conn;
    public $error;

    public function connect() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);

        if ($this->conn->connect_error) {
            $this->error = "Fatal Error: Can't connect to database - " . $this->conn->connect_error;
            return false;
        }
        return $this->conn; // Return the connection on success
    }
}
?>
