<?php
  include_once './database.php';
  include_once './feedbackMessages.php';
  include_once './validationForm.php';

  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
  header('Access-Control-Allow-Headers: token, Content-Type, access');
  header("Access-Control-Allow-Credentials: true");
  header("Content-Type: application/json; charset=UTF-8");

  $restJson = file_get_contents('php://input');

  $data = json_decode($restJson, true);

  $errorMessages = validationForm($data);

  if ($errorMessages['name'] || $errorMessages['email'] || $errorMessages['phone'] || $errorMessages['message']) {
    echo json_encode(["isEmail" => false, 'answer' => '', "errorMessages" => $errorMessages]);
    die();
  }

  $database = new Database();
  $conn = $database->connection();

  $feedback = new FeedbackMessages($conn);

  $feedback->name = $data['name'];
  $feedback->phone = $data['phone'];
  $feedback->email = $data['email'];
  $feedback->message = $data['message'];

  if($feedback->findEmail()) {
    echo json_encode(["isEmail" => true, 'answer' => 'С данной почты уже отправляли сообщение.', "errorMessages" => $errorMessages]);
    die();
  }

  $feedback->insertData();

  mysqli_close($conn);

  if ($data ) {
    http_response_code(200);

    [
      'name' => $name,
      'email' => $email,
      'phone' => $phone,
      'message' => $message
    ] = $data ;

    $to = 'ncpremote@mail.ru';

    $headers = "MIME-Version: 1.0\r\n";
	  $headers.= "Content-type: text/html; charset=UTF-8\r\n";
	  $headers.= "From: <" . $email . ">";
    
    mail($to, $name, $message, $headers);

    echo json_encode(['isEmail' => false ,'answer' => 'Спасибо за сообщение.', "errorMessages" => $errorMessages]);
  }
  else {
    http_response_code(404);
    echo json_encode(["isEmail" => false, "answer" => 'Произошла ошибка.', "errorMessages" => $errorMessages]);
  }
?>
