<?php
session_start();
$pdo = new PDO('mysql:hosts=localhost;dbname=task-manager','root','root');
$data = $_GET['id'];
function deleteTask($pdo, $data)
{
    $sql = "DELETE FROM tasks WHERE id = $_SESSION[user_id]";
    $statement = $pdo->prepare($sql);
    $statement->bindParam('user_id', $data);
    $statement->execute();
}
/*$sql = "DELETE FROM tasks WHERE id = $SASSION[user_id]";*/
if ($pdo->query($sql) === TRUE){
    echo 'Запись удалеа';
    exit;
}

header('Location:list.php');
?>
