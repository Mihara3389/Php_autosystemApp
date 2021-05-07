<?php
session_start();
//フォームからの値をチェック
if ((isset($_POST["username"])) and (isset($_POST['password'])))
{
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
}else if(!isset($_POST["username"]))
{
  $username = null;
  echo "ユーザー名が未入力です。";
}else 
{
    $password = null;
    echo "パスワードが未入力です。。";
}
//データベース接続処理
require('dbconnect.php');

$sql = "SELECT * FROM user WHERE username = :username";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':username', $username);
$stmt->execute();
//usernameに一致するものを1行取得
$member = $stmt->fetchColumn();
$key = strcmp($member, $username);
//ユーザー名と指定したハッシュがパスワードにマッチしているかチェック
if (($key === 0) and (password_verify($_POST['password'], $member['password']))) {
    //DBのユーザー情報をセッションに保存
    $_SESSION['id'] = $member['id'];
    $_SESSION['name'] = $member['username'];
    header("location: index.php");
} else {
    $errorMessage = "ユーザー名もしくはパスワードが間違っています。";
}
?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>