<?php
session_start();
//Проверка на регистрацию
if(!isset($_SESSION['user_id'])) {
    header('Location: /login-form.php');
    exit;
}

//Подключение к БД
$pdo = new PDO('mysql:hosts=localhost;dbname=task-manager','root','root');

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
    'id'=>$_GET['id'],
    'title'=>$_POST['title'],
    'description'=>$_POST['description'],
    'image'=>$imageName,
    'user_id'=>$_POST['user_id']
];
var_dump($data);

//Проверка данных
/*foreach ($data as $value){
    if(empty($value)){
        require 'errors.php';
        exit();
    }
}*/

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

//header('Location: /list.php');
?>
