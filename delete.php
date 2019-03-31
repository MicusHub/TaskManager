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
/*$sql = "DELETE FROM tasks WHERE id = $SASSION[user_id]";
if ($pdo->query($sql) === TRUE){
    echo 'Запись удалеа';
    exit;
} */

header('Location:list.php');
?>
