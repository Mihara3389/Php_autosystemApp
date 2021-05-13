<?php
session_start();
//ログインセッションを確認
if (isset($_SESSION['id']))
 {
    //データベースへ接続
    require('dbconnect.php');
    //チェックボタンが押された場合
    if (isset($_POST["Delete"])) {
        //画面より質問idを取得する
        $id = $_POST['id'];
        //idが取得できていなかったらエラー
        if (empty($id)) {
           $_SESSION['msg'] = "問題idが取得できませんでした。";
           header("location: delete_form.php");
        }
        //delete
        $sql = "DELETE questions, correct_answers FROM questions INNER JOIN correct_answers ON questions.id = correct_answers.question_id WHERE questions.id = :qid;";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':qid', $id);
        $stmt->execute();
        //削除をしたらリスト画面へ戻る
        require('listGather.php');
    }else if(isset($_POST["Return"])){
        //リスト画面へ戻る
        require('listGather.php');
    }else{
        $_SESSION['msg'] = "idが取得できませんでした。";
        header("location: delete_form.php");
    }
  }else{
        $_SESSION['msg'] = "セッションが切れています。";
        header("location: login_form.php");
}
?>