<?php
//Получение данных из $_POST
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

//Проверка данных ВАЛИДАЦИЯ
foreach ($_POST as $input) {
    if (empty($input)) {
        include 'errors.php';
        exit;
    }
}

//Подготовка и выполнение запроса к БД (проверка - существует ли пользователь с такими данными в БД)
$pdo = new PDO('mysql:hosts=localhost;dbname=task-manager','root','root'); //Соединение с БД
$sql = 'SELECT id from users where email=:email'; // Подготовка
$statement = $pdo->prepare($sql);                 // запроса к БД
$statement->execute([':email' => $email]); // Выполнение запроса
$user = $statement->fetchColumn();  //Результат полученный из БД
if($user) {   //Если пользователь с анологичными данными уже существует
    $errorMessage = 'Пользователь с таким email уже существует'; //Вывод ошибки
    include 'errors.php';
    exit; //Останавливает скрипт
}

//Сохранение данных пользователя в БД
$sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
$statement = $pdo->prepare ($sql);

//password hash хэширование пароля
/*$_POST['password'] = md5($_POST['password']);
$result = $statement->execute($_POST);
if(!$result) {
    $errorMessage = 'Ошибка регистрации';
    include 'errors.php';
    exit;
} */
//Переадресация на авторизацию (login-form.php)
header('Location: /login-form.php');
exit;

?>
