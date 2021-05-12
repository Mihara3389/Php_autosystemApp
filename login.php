<?php
session_start();
// エラーメッセージの初期化
$err_list = [];
//変数初期化
$username ="";
$password ="";
//フォームからの値をそれぞれ変数に代入とチェック
if (isset($_POST["Login"])) {
    //バリデーションチェック
    if (empty($_POST["username"])) {  // 値が空のとき
        $_SESSION['msg_user'] = "ユーザー名が未入力です。";
        $err_list = $_SESSION;
    }elseif (empty($_POST["password"])) {// 値が空のとき
        $_SESSION['msg_pass'] = "パスワードが未入力です。";
        $err_list = $_SESSION;
    }elseif (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        //データベース接続処理
        require('dbconnect.php');
        //フォームに入力されたusernameがすでに登録されているものかチェック
        $sql = "SELECT * FROM user WHERE username = :username";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        //usernameに一致するものを1行取得
        $member = $stmt->fetch();
        $key = strcmp($member['username'], $username);
        //ユーザー名と指定したハッシュがパスワードにマッチしているかチェック
        if (($key === 0) and (password_verify($_POST['password'], $member['password']))) {
            //DBのユーザー情報をセッションに保存
            $_SESSION['id'] = $member['id'];
            $_SESSION['name'] = $member['username'];
        }else{
            $_SESSION['msg'] = "ユーザー名もしくはパスワードが間違っています。";
            $err_list = $_SESSION;
        }
        if (count($err_list) > 0) {
            //login_formへ遷移
            header('location: login_form.php');
            return;
        } else{
             //topへ遷移
            header("location: index.php");
        }
    } 
    if (count($err_list) > 0) {
        //login_formへ遷移
        header('location: login_form.php');
        return;
    }
}
?>