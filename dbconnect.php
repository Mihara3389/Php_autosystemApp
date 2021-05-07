<?php
//データベース接続
require_once 'env.php';
$host = DB_HOST;
$dbname = DB_NAME;
$dbuser = DB_USER;
$dbpass = DB_PASS;

$dsn = "mysql:dbname=$dbname;host=$host;charset=utf8";
//PDOの例外エラーを詳細にしてくれるオプションとselect文やwhere句などの結果を連想配列として返してくれるオプション
$dboption = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
  
try {
     $dbh = new PDO($dsn, $dbuser, $dbpass, $dboption);
}catch (PDOException $e) {
     echo "接続に失敗しました\n";
     echo $e->getMessage() . "\n";
     exit();
}
?>