<?php
$pdo = new PDO('mysql:hosts=localhost;dbname=task-manager','root','root');

$id = $_GET['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$imageName=uploadImage($_FILES['image']);
$user_id = $_POST['user_id'];

$sql = 'INSERT INTO tasks (id, title, description, image, user_id) VALUES (:id, :title, :description, :image, :user_id)';
$statement = $pdo->prepare ($sql);
?>
