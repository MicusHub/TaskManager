<?php
session_start();
//Проверка id сессии
if(!isset($_SESSION['user_id'])) {
    header('Location: /login-form.php');
    exit;
}

//Подключение к БД
require_once('handler.php');

//Функция обработчик файла (картинки)
$imageName = uploadImage($_FILES['image']);

//Получение данных
$data=[
    'user_id'=>$_SESSION['user_id'],
    'title'=>$_POST['title'],
    'description'=>$_POST['description'],
    'image'=>$imageName
];

//Валидация
foreach ($data as $value){
    if(empty($value)){
        require 'errors.php';
        exit();
    }
}

//Функция передачи данных в БД
addTask($data, $pdo);

//Переадресация на страницу создания задач
header('Location: /list.php');
exit;
?>

