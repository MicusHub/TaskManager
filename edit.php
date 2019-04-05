<?php
session_start();
//Проверка на регистрацию
if(!isset($_SESSION['user_id'])) {
    header('Location: /login-form.php');
    exit;
}

//Подключение к БД
$pdo = new PDO('mysql:hosts=localhost;dbname=task-manager','root','root');

//Валидация
foreach ($data as $value){
    if(empty($value)){
        require 'errors.php';
        exit();
    }
}

//Получение и обработка файла
$imageName=uploadImage($_FILES['image']);
function uploadImage($image) {
    $name_img = $image['name'];
    $tmp_name = $image['tmp_name'];
    $imageType = pathinfo($name_img, PATHINFO_EXTENSION); //Определение формата изображения
    $imageName = uniqid() . '.' . $imageType;
    move_uploaded_file($tmp_name, "uploads/" . $imageName); //Перенесение полученного файла в папку uploads
    return $imageName;
}
$data=[
    'task_id'=>$_GET['id'],
    'user_id'=>$_SESSION['user_id'],
    'title'=>$_POST['title'],
    'description'=>$_POST['description'],
    'image'=>$imageName
];

//Выполнение запроса
update($pdo, $data);
function update($pdo, $data)
{
    $str_data = '';
    foreach ($data as $key => $value) {
        $str_data .= $key . "=:$key, ";
    }
    $str_data = rtrim($str_data, ", ");
    $sql = "UPDATE tasks SET $str_data WHERE task_id =:id";
    $statement = $pdo->prepare($sql);
    $statement->execute($data);
}

//Удаление предыдущей картинки
if(file_exists('uploads/' . $task['image'])) {
    unlink('uploads/' . $task['image']);
}

//Переадресация на страницу создания задач
header('Location: /list.php');
exit;
?>
