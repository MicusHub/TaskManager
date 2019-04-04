<?php
$pdo = new PDO('mysql:hosts=localhost;dbname=task-manager','root','root');
$id=$_GET['id']; //Вывести задачу из БД
$task=oneTask($pdo, $id);
function oneTask($pdo, $data){
    $sql = "SELECT * FROM tasks WHERE task_id=:id";
    $statement=$pdo->prepare($sql);
    $statement->bindParam(':id', $data);
    $statement->execute();
    $task=$statement->fetch(PDO::FETCH_ASSOC);
    return $task;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Edit Task</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" method="post" action="edit.php?id=<?= $id; ?>" enctype="multipart/form-data">
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Редактировать запись</h1>
          <input type="hidden" name="user_name" value="<?=$task['user_id']?>">
        <label for="inputEmail" class="sr-only">Название</label>
        <input type="text" id="inputEmail" name="title" class="form-control" placeholder="Название" required value="<?=$task['title']?>">
        <label for="inputEmail" class="sr-only">Описание</label>
        <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Описание"><?=$task['description']?></textarea>
        <input type="file" name="image">
        <img src="/uploads/<?=$task['image']?>" alt="" width="300" class="mb-3">
        <button class="btn btn-lg btn-success btn-block" type="submit">Редактировать</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>
