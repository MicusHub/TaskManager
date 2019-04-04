<?php
session_start();

//Проверка- авторизован ли пользователь
if(isset($_SESSION['email'])){ //Если пользователь зарегистрирован, то он переадресовуется на index.php
    header( 'location: /list.php');
}

//Получение данных от пользователя
/*$data=[
    'email'=>$_POST['email'],
    'password'=>md5($_POST['password'])
];*/
$email = $_POST['email'];
$password = md5($_POST['password']);
$remember = $_POST['remember'];

//Валидация полученных данных
/*if ($data($_POST !='TRUE')){
    require "login-form.php";
    exit();
}*/
foreach ($_POST as $input){ //Проверка на пустоту
    if (empty($email && $password)){
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
$pdo = new PDO('mysql:host=localhost; dbname=task-manager', 'root', 'root');
$sql = 'SELECT id, username, email FROM users WHERE email=:email AND password=:password';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email, ':password' => $password]);
$user = $statement->fetch(PDO::FETCH_ASSOC);
//Если такого пользователя тет в БД
if(!$user){
    $errorMessage = 'Неправильный логин или пароль';
    include 'errors.php';
    exit;
}

//Создание сессии
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['email'] = $user['email'];

//Кнопка запомнить меня
if($remember != null){
    //Создать куки
    setcookie('login', md5($_COOKIE['PHPSESSID']), time() + 3600 * 3);
}
//Переадресация на главную
header("Location: /list.php");
exit;
?>