<?php
session_start();

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
var_dump($data);

//Валидация
foreach ($data as $value){
    if(empty($value)){
        require 'errors.php';
        exit();
    }
}

//Передача данных в БД
$sql='INSERT INTO tasks(title, description, image, user_id)VALUES (:title, :description, :image, :user_id)';
$statement=$pdo->prepare($sql);
$statement->execute($data);



//Переадресация на страницу создания задач
header('Location: /list.php');
exit;

?>

