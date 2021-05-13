<?php
session_start();
$username = $_SESSION['name'];
if (isset($_SESSION['id'])) {//ログインしているときはTop画面へ遷移
    header("location: top_form.php");
} else {//ログインしていない時はログイン画面へ戻る
    header("location: login_form.php");
}
?>