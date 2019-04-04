<?php
session_start();

$pdo = new PDO('mysql:hosts=localhost;dbname=task-manager','root','root');

$data = $_GET['id'];
deleteTask($pdo , $data);
function deleteTask($pdo, $data){
    $sql="DELETE FROM tasks WHERE task_id=:id";
    $statement = $pdo->prepare($sql);
    $statement->bindParam('id', $data);
    $statement->execute();
}

header('Location:list.php');
?>
