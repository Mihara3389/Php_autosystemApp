<?php
session_start();
// エラーメッセージの初期化
$err = [];
//変数初期化
$username ="";
$password ="";
//フォームからの値をそれぞれ変数に代入とチェック
if (isset($_POST["Signup"])) {
    //バリデーションチェック
    if (empty($_POST["username"])) {  // 値が空のとき
        $_SESSION['msg_user'] = "ユーザー名が未入力です。";
        $err = $_SESSION;
   } elseif (empty($_POST["password"])) {// 値が空のとき
        $_SESSION['msg_pass'] = "パスワードが未入力です。";
        $err = $_SESSION;
    }elseif (!empty($_POST["username"]) && !empty($_POST["password"])) {
        // 入力したユーザー名とパスワードを格納
        $username = $_POST["username"];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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
        if ($key === 0) {
            $_SESSION['msg'] = "入力されたユーザー名はすでに登録済です。";
            $err = $_SESSION;
        }
        if (count($err) > 0) {
            $_SESSION = $err;
            //signupへ遷移
            header('location: signup.php');
            return;
        } else {
            //insert
            $sql = "INSERT INTO user(username, password, created_at) VALUES (:username, :password, :created_at)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':created_at', $now);
            $stmt->execute();
            //login_formへ遷移
            header('location: login_form.php');
        }
    }
}
?>