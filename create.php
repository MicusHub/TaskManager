<?php
session_start();
//Проверка id сессии
if(!isset($_SESSION['user_id'])) {
    header('Location: /login-form.php');
    exit;
}

//Подключение к БД
$pdo = new PDO('mysql:hosts=localhost;dbname=task-manager','root','root');

//Обработка файлов
$imageName = uploadImage($_FILES['image']);
function uploadImage($image) {
    $name_img = $image['name'];
    $tmp_name = $image['tmp_name'];
    $imageType = pathinfo($name_img, PATHINFO_EXTENSION); //Определение формата изображения
    $imageName = uniqid() . '.' . $imageType;
    move_uploaded_file($tmp_name, "uploads/" . $imageName); //Перенесение полученного файла в папку uploads
    return $imageName;
}

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

//Передача данных в БД
$sql='INSERT INTO tasks (user_id, title, description, image) VALUES (:user_id, :title, :description, :image)';
$statement=$pdo->prepare($sql);
$statement->execute($data);

//Переадресация на страницу создания задач
header('Location: /list.php');
exit;
?>

