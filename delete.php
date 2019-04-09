<?php
session_start();

require_once('handler.php');

$data = $_GET['id'];
deleteTask($pdo , $data);

//Удаление картинки из папки uploads
if(file_exists('uploads/' . $task['image'])) {
    unlink('uploads/' . $task['image']);
}

header('Location:list.php');
?>
