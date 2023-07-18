<?php

class Database
{
  private $host='localhost';
  private $port='3306';
  private $dbName = 'feedback-form';
  private $username = 'root';
  private $password = '';
  public $conn;

  public function connection()
  {
    $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbName);

    if ($this->conn == false) {

      return null;
    }
    else {

      return $this->conn;
    }
  }

  public function disconnection() {
    mysqli_close($this->conn);
  }
}