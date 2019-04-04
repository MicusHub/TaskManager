<?php
$pdo = new PDO('mysql:hosts=localhost;dbname=task-manager','root','root');

$imageName=uploadImage($_FILES['image']);
$data=[
    'id'=>$_GET['id'],
    'title'=>$_POST['title'],
    'description'=>$_POST['description'],
    'image'=>$imageName,
    'user_id'=>$_POST['user_id']
];

function update($pdo, $data)
{
    $str_data = '';
    foreach ($data as $key => $value) {
        $str_data .= $key . "=:$key, ";
    }
    $str_data = rtrim($str_data, ", ");
    $sql = "UPDATE tasks SET $str_data WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute($data);
}
?>
