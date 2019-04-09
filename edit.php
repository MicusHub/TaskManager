<?php
session_start();
//Подключение файла ошибок
include 'begin.php';

//Проверка на регистрацию
if(!isset($_SESSION['user_id'])) {
    header('Location: /login-form.php');
    exit;
}

//Подключение файла-обработчика
require_once('handler.php');

//Функция получение и обработка файла
$imageName=uploadImage($_FILES['image']);
/*$image = $_FILES['image'];
if (!empty($image['name'])){
    $imageName=uploadImage($_FILES['image']);
}*/

//Получение данных
$data=[
    'id'=>$_GET['id'],
    'user_id'=>$_SESSION['user_id'],
    'title'=>$_POST['title'],
    'description'=>$_POST['description'],
    'image'=>$imageName
];

//Функция выполнение запроса
update($pdo, $data);

//Переадресация на страницу создания задач
header('Location: /list.php');
exit;

?>
