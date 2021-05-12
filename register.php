<?php
session_start();
// エラーメッセージの初期化
$err_list = [];
//変数初期化
$username ="";
$password ="";
$answer_array = [];
//現在時刻を取得
date_default_timezone_set('Asia/Tokyo');
$now = date("Y/m/d G:i:s");
//フォームからの値をそれぞれ変数に代入とチェック
if (isset($_POST["Signup"])) {
    //バリデーションチェック
    if (empty($_POST["username"])) {  // 値が空のとき
        $_SESSION['msg_user'] = "ユーザー名が未入力です。";
        $err_list = $_SESSION;
   } elseif (empty($_POST["password"])) {// 値が空のとき
        $_SESSION['msg_pass'] = "パスワードが未入力です。";
        $err_list = $_SESSION;
    }elseif (!empty($_POST["username"]) && !empty($_POST["password"])) {
        // 入力したユーザー名とパスワードを格納
        $username = $_POST["username"];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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
            $err_list = $_SESSION;
        }
        if (count($err_list) > 0) {
            $_SESSION = $err_list;
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
}elseif(isset($_POST["Register"])){
    //入力値を取得する
    $question = $_POST['question'];
    $answer_array = $_POST['answer'];
    //データベース接続処理
    require('dbconnect.php');
    //問題のinsert
    $sql = "INSERT INTO questions(question, created_at, updated_at) VALUES (:question, :created_at, :updated_at)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':question', $question);
    $stmt->bindValue(':created_at', $now);
    $stmt->bindValue(':updated_at', $now);
    $stmt->execute();
    //問題のidを取得
    $sql = "SELECT * FROM questions WHERE question = :question";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':question', $question);
    $stmt->execute();
    $question_id = $stmt->fetch(PDO::FETCH_ASSOC);
    $qid = $question_id['id'];
    //答えのinsert
    foreach($answer_array as $answer){
        $sql = "INSERT INTO correct_answers(question_id, answer,created_at, updated_at) VALUES (:question_id, :answer, :created_at, :updated_at)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':question_id',$qid );
        $stmt->bindValue(':answer', $answer);
        $stmt->bindValue(':created_at', $now);
        $stmt->bindValue(':updated_at', $now);
        $stmt->execute();        
    }
    //リストへ戻る
    require('list.php');
}elseif(isset($_POST["Return"])){
    //リストへ戻る
    require('register.php');
}
?>