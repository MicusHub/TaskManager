<?php
//Подключение к БД
$pdo = new PDO('mysql:host=localhost; dbname=task-manager', 'root', 'root');

function register($data, $pdo) {
//Подготовка запроса к БД
    $sql = 'SELECT * from users where email=:email';
    $statement = $pdo->prepare($sql);
    $statement->execute([':email'=>$data['email']]); //Выполнение запроса
    $user = $statement->fetchColumn(); //Результат полученый из БД
    if ($user) {   //Если пользователь с анологичными данными уже существует
        $errorMessage = 'Пользователь с таким email уже существует'; //Вывод ошибки
        include 'errors.php';
        exit; //Останавливает скрипт
    }
//Сохранение данных пользователя в БД
    $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
    $statement = $pdo->prepare($sql);
//password hash хэширование пароля
    $_POST['password'] = md5($_POST['password']);
    $result = $statement->execute($_POST);
    if (!$result) {
        $errorMessage = 'Ошибка регистрации';
        include 'errors.php';
        exit;
    }
}

function login($data, $pdo) {
//Найти пользователя в БД
    $sql = 'SELECT * FROM users WHERE email=:email AND password=:password';
    $statement = $pdo->prepare($sql);
    $statement->execute($data);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
//Если такого пользователя тет в БД
    if (!$user) {
        $errorMessage = 'Неправильный логин или пароль';
        include 'errors.php';
        exit;
    }
//Создание сессии
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
}

function userTasks($pdo){
    $sql="SELECT * FROM tasks WHERE user_id=:user_id";
    $statement=$pdo->prepare($sql);
    $statement->execute([':user_id' =>  $_SESSION['user_id']]);
    $tasks=$statement->fetchAll(PDO::FETCH_ASSOC);
    return $tasks;
}

function moreTask($pdo, $data) {
    $sql = "SELECT * FROM tasks WHERE id=:id";
    $statement=$pdo->prepare($sql);
    $statement->bindParam(':id', $data);
    $statement->execute();
    $task=$statement->fetch(PDO::FETCH_ASSOC);
    return $task;
}

function uploadImage($image) {
    $name_img = $image['name'];
    $tmp_name = $image['tmp_name'];
    $imageType = pathinfo($name_img, PATHINFO_EXTENSION); //Определение формата изображения
    $imageName = uniqid() . '.' . $imageType;
    move_uploaded_file($tmp_name, "uploads/" . $imageName); //Перенесение полученного файла в папку uploads
    return $imageName;
}

function addTask($data, $pdo) {
//Передача данных в БД
    $sql = 'INSERT INTO tasks (user_id, title, description, image) VALUES (:user_id, :title, :description, :image)';
    $statement = $pdo->prepare($sql);
    $statement->execute($data);
}

function update($pdo, $data) { //Выполнение запроса
    $str_data = '';
    foreach ($data as $key => $value) {
        $str_data .= $key . "=:$key, ";
    }
    $str_data = rtrim($str_data, ", ");
    $sql = "UPDATE tasks SET $str_data WHERE id =:id";
    $statement = $pdo->prepare($sql);
    $statement->execute($data);
}

function deleteTask($pdo, $data){
    $sql="DELETE FROM tasks WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $statement->bindParam('id', $data);
    $statement->execute();
}