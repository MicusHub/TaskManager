<?php
//Получение данных из $_POST
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

//Проверка данных
foreach ($_POST as $input) {
    if (empty($input)) {
        include 'errors.php';
        exit;
    }
}

//Подготовка и выполнение запроса к БД
$pdo = new PDO('mysql:hosts=localhost;dbname=task-manager','root','');
$sql = 'SELECT id from users where email=:email';
$statement = $pdo->prepare($sql);
$statement->execute([':email' -> $email]);
$user = $statement->fetchColumn();
if($user) {
    $errorMessage = 'Пользователь с таким email уже существует';
    include 'errors.php';
    exit;
}

//Сщчранение в базу
$sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
$statement = $pdo->prepare ($sql);

//password hash хэширование пароля
$_POST['password'] = md5($_POST['password']);
$result = $statement->execute($_POST);
if(!$result) {
    $errorMessage = 'Ошибка регистрации';
    include 'errors.php';
    exit;
}
//Переадресация на авторизацию (login-form.php)
header('Location: /login-form.php');
exit;

?>
