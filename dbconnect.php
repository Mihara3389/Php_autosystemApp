<?php
//データベース接続
$host = 'localhost';
$dbname = 'phpApp';
$dbuser = 'hoge';
$dbpass = 'himitu';

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