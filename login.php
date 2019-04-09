<?php
session_start();

//Проверка- авторизован ли пользователь
if(isset($_SESSION['email'])){ //Если пользователь зарегистрирован, то он переадресовуется на index.php
    header( 'location: /list.php');
}

require_once('handler.php');

//Получение данных от пользователя
$data=[
    'email'=>$_POST['email'],
    'password'=>md5($_POST['password'])
];
$remember = $_POST['remember'];

//Валидация полученных данных
foreach ($_POST as $input){ //Проверка на пустоту
    if (empty($data['email'] || $data['password'])){
        include 'errors.php';
        exit;
    }
}
/*if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ //Проверка синтаксиса имейла (@)
    $errorMessage = "E-mail адрес $email указан неверно.\n"; //НЕ СМОГ ПРИДУМАТЬ КАК В СТРОКЕ ОШИБКИ, ВЫВЕСТИ ИМЕЙЛ ПОЛЬЗОВАТЕЛЯ (пробовал {$data['email']} )
    include 'errors.php';
    exit;
}*/

login($data, $pdo);

//Кнопка запомнить меня
if ($remember != null) {
    //Создать куки
    setcookie('login', md5($_COOKIE['PHPSESSID']), time() + 3600 * 3);
}

//Переадресация на главную
header("Location: /list.php");
exit;
?>