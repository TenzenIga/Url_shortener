<?php
class DataBase
{
    private $charset="utf8";
    private $host = 'localhost';
    private $db_name = 'test';
    private $user = 'root';
    private $password = '******';
    private $conn;
    public function connect()
    {
      $this->conn = null;
      try {
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name  . ';charset=' . $this->charset, $this->user, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (\Exception $e) {
        echo 'Connection Error ' . $e->getMessage();
      }
      return $this->conn;
    }
}

 ?>
