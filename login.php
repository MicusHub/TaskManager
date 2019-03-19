<?php
//Проверка- авторизован ли пользователь
if(isset($_SESSION['email'])){ //Если пользователь зарегистрирован, то он переадресовуется на index.php
    header( 'location: /indwx.php');
}

//Получение данных от пользователя
$email = $_POST['email'];
$password = md5($_POST['password']);
$remember = $_POST['remember'];

//Валидация полученных данных
foreach ($_POST as $input){ //Проверка на пустоту
    if (empty($input)){
        include 'errors.php';
        exit;
    }
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ //Проверка синтаксиса имейла (@)
    $errorMessage = "E-mail адрес $email указан неверно.\n";
    include 'errors.php';
    exit;
}

//Найти пользователя в БД
$pdo = new PDO('mysql:host=localhost; dbname=tasks', 'root', 'root');
$sql = 'SELECT id from users where email=:email and password=:password';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email, ':password' => $password]);
$user = $statement->fetchColumn();
if(!$user){
    $errorMessage = 'Неправильный логин или пароль';
    include 'errors.php';
    exit;
}

//Создание сессии
session_start();
$_SESSION['email'] = $_POST['email'];

//Кнопка запомнит меня
if($remember != null){
    //Создать куки
    setcookie('login', md5($_COOKIE['PHPSESSID']), time() + 3600 * 3);
}

//Переадресация на главную
header("Location: /index.php");
exit;

?>
