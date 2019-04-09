<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header('Location: /login-form.php');
    exit;
}

//удаление сессии
unset($_SESSION['user_id']);
unset($_SESSION['email']);

//Удаление куки
setcookie('login', md5($_COOKIE['PHPSESSID']), time() - 1);
session_destroy();
header('Location:login-form.php');
exit;
?>
