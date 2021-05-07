<?php
//フォームからの値をそれぞれ変数に代入とチェック
if ((isset($_POST["username"])) and (isset($_POST['password'])))
{
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
}else if(!isset($_POST["username"]))
{
  $username = null;
  echo "no username supplied";
}else 
{
    $password = null;
    echo "no password supplied";
}
//現在時刻を取得
date_default_timezone_set('Asia/Tokyo');
$now = date("Y/m/d G:i:s");
//データベース接続処理
require('dbconnect.php');

//フォームに入力されたusernameがすでに登録されていないかチェック
$sql = "SELECT username FROM user WHERE username = :username";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':username', $username);
$stmt->execute();
//usernameに一致するものを1行取得
$member = $stmt->fetchColumn();
$key = strcmp($member, $username);
if ($key === 0){
    $msg = '*入力された名前はすでに登録済です。';
    $link = '<a href="signup.php">戻る</a>';
} else {
    //登録されていなければinsert 
    $sql = "INSERT INTO user(username, password, created_at) VALUES (:username, :password, :created_at)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    $stmt->bindValue(':created_at', $now);
    $stmt->execute();
    header("location: login_form.php");
}
?>

<h1><?php echo $msg; ?></h1><!--メッセージの出力-->
<?php echo $link; ?>