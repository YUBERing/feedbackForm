<?php
function validationForm($data) {
  $errorMessages = ['name' => '', 'email' => '', 'phone' => '', 'message' => ''];

  switch (false) {
    case !empty($data['name']):
      $errorMessages['name'] = 'Заполните поле имя.';
      break;
    case (strlen($data['name']) >= 3):
      $errorMessages['name'] = 'Имя должно быть не менее 3 символов.';
      break;
    case preg_match('/^[a-zA-Zа-яА-Я]+$/u', $data['name']):
      $errorMessages['name'] = 'Используйте только буквы';
      break;
  }

  switch (false) {
    case !empty($data['email']):
      $errorMessages['email'] = 'Заполните поле email.';
      break;
    case preg_match('/\w+@\w+\.\w+/', $data['email']):
      $errorMessages['email'] = 'Email не соответствуте формату';
      break;
  }

  switch (false) {
    case !empty($data ['phone']):
      $errorMessages['phone'] = 'Заполните поле телефон.';
      break;
    case strlen($data ['phone']) == 11:
      $errorMessages['phone'] = 'Телефон должен быть не менее 11 символов.';
      break;
    case preg_match('/^\d+$/', $data ['phone']):
      $errorMessages['phone'] = 'Используйте только цифры';
      break;
  }

  switch (false) {
    case strlen($data ['message']) <= 255:
      $errorMessages['message'] = 'В сообщении не может быть больше 255 символов.';
      break;
  }

  return $errorMessages;
}