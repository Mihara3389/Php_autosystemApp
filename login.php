<?php
session_start();
$username = $_POST['username'];
$dsn = "mysql:host=localhost; dbname=phpApp; charset=utf8";
$dbuser = "hoge";
$dbpass = "himitu";
try {
    $dbh = new PDO($dsn, $dbuser, $dbpass);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

$sql = "SELECT * FROM user WHERE username = :username";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':username', $username);
$stmt->execute();
$member = $stmt->fetch();
//指定したハッシュがパスワードにマッチしているかチェック
if (password_verify($_POST['password'], $member['password'])) {
    //DBのユーザー情報をセッションに保存
    $_SESSION['id'] = $member['id'];
    $_SESSION['name'] = $member['username'];
    $msg = 'ログインしました。';
    $link = '<a href="index.php">ホーム</a>';
} else {
    $msg = 'ユーザー名もしくはパスワードが間違っています。';
    $link = '<a href="AutoSystem/login_form.php">戻る</a>';
}
?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>