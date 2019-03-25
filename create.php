<?php
session_start();
//Получение данных из create form
$title = $_POST['title'];
$description = $_POST['description'];
//ВООБЩЕ НЕ ИМЕЮ ПОНЯТИЯ КАК ПЕРЕДАВАТЬ ИЗОБРАЖЕНИЕ В БД
$image = $_FILES['image'];

/*if (!$_POST['$description']) {
    $errorMassage = "Поле 'задание' не заполнено";
    //include 'errors.php';
} */

//Проверка данных на пустоту
//МОЁ СОБСТВЕННОЕ СООБЩЕНИЕ $errorMassage НЕ ОТРАБАТЫВАЕТ, ВЫВОДИТСЯ СООБЩЕНИЕ ИЗ ERROR.PHP
foreach ($_POST as $input) {
    if (empty($input)) {
        $errorMassage = "Поле 'задание' не заполнено";
        include 'errors.php';
        exit;
    }
}

//Подключение к БД
$pdo = new PDO('mysql:hosts=localhost;dbname=task-manager','root','root'); //Соединение с БД
//Подготовка запроса к БД
/*$sql = 'SELECT id from tasks where title=:title';
$statement = $pdo->prepare($sql);
//Выполнение запроса
$statement->execute([':title' => $title]);
//Результат полученый из БД
$task = $statement->fetchColumn();
if($task) {
    $errorMessage = 'Задание с таким заголовком уже существует'; //Вывод ошибки
    include 'errors.php';
    exit; //Останавливает скрипт
} */

//Сохранение данных пользователя в БД
//ДАННЫЕ ПРИХОДЯТ В POST, НО НЕ ОТПРАВЛЯЮТСЯ В БД
$sql = 'INSERT INTO tasks (title, description,) VALUES (:title, :description)';
var_dump($sql);
$statement = $pdo->prepare ($sql);
//Результат
$result = $statement->execute($_POST);
if(!$result) {
    $errorMessage = 'Задача не передаётся в БД';
    include 'errors.php';
    exit;
}


//Переадресация на страницу создания задач
/*header('Location: /list.php');
exit;*/

?>

