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
//データベース接続情報
$dsn = "mysql:host=localhost; dbname=phpApp; charset=utf8";
$dbuser = "hoge";
$dbpass = "himitu";
try {
    $dbh = new PDO($dsn, $dbuser, $dbpass);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

//フォームに入力されたusernameがすでに登録されていないかチェック
$sql = "SELECT username FROM user WHERE username = :username";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':username', $username);
$stmt->execute();
//usernameに一致するものを1行取得
$member = $stmt->fetchColumn();
$key = strcmp($member, $username);
if ($key === 0){
    $msg = '同じユーザー名が存在します。';
    $link = '<a href="signup.php">戻る</a>';
} else {
    //登録されていなければinsert 
    $sql = "INSERT INTO user(username, password, created_at) VALUES (:username, :password, :created_at)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    $stmt->bindValue(':created_at', $now);
    $stmt->execute();
    $msg = '会員登録が完了しました';
    $link = '<a href="login_form.php">ログインページ</a>';
}
?>

<h1><?php echo $msg; ?></h1><!--メッセージの出力-->
<?php echo $link; ?>