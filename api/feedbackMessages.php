<?php
class FeedbackMessages {
  private $tableName = 'feedback-messages';
  private $conn;

  public $name;
  public $phone;
  public $email;
  public $message;

  public function __construct($conn) {
    $this->conn = $conn;
  }

  function insertData() {
    $query = "INSERT INTO `". $this->tableName ."` (`name`, `phone`, `email`, `message`) VALUES ('". $this->name ."', '". $this->phone ."', '". $this->email ."', '". $this->message ."')";

    $res = mysqli_query($this->conn, $query);

    if ($res == false) {
      echo "Произошла ошибка при выполнении.";
    }
  }

  function findEmail() {
    $query = "SELECT `id`, `name`, `phone`, `email`, `message` FROM `". $this->tableName ."` WHERE `email` = '". $this->email ."'";

    $res = mysqli_query($this->conn, $query);

    if ($res == false) {
      echo "Произошла ошибка при выполнении.";
    }

    $row = mysqli_num_rows($res);

    if ($row > 0) {
      return true;
    }

    return false;
  }
}