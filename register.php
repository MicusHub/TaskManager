<?php
//Получение данных из $_POST
$data=[
    'name'=>$_POST['name'],
    'email'=>$_POST['email'],
    'password'=>$_POST['password']
];

//Проверка данных ВАЛИДАЦИЯ
foreach ($_POST as $input) {
    if (empty($input)) {
        include 'errors.php';
        exit;
    }
}

//Подключение к файлу-обработчику
require_once('handler.php');

//Функция обработки данных
register($data, $pdo);

//Переадресация на авторизацию (login-form.php)
header('Location: /login-form.php');
exit;
?>