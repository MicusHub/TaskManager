<?php
require_once('handler.php');

$data = $_GET['id'];
$task = moreTask($pdo , $data);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Show</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">
      <img src="/uploads/<?=$task['image']?>" alt="" width="400">
      <h2><?=$task['title']?></h2>
      <p>
          <?=$task['description']?>
      </p>
        <a href="list.php" class="btn btn-secondary">Вернуться в список задач</a>
    </div>
  </body>
</html>
