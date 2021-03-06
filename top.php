<?php
session_start();
// エラーメッセージの初期化
$err_list = [];
//変数初期化
$members =[];
$qa_list = [];
//ログインセッションを確認
if (isset($_SESSION['id']))
 {
    //データベースへ接続
    require('dbconnect.php');
    //セッションよりidとユーザー名を取得する
    $id = $_SESSION['id'];
    //フォームからの値をチェック
    if (isset($_POST["list"])) {
        //リストの呼び出し
        require('listGather.php');
    }else if(isset($_POST["test"]))
    {
        //questionデータを取得する
        $sql = "SELECT DISTINCT questions.id as qid, questions.question as q FROM questions INNER JOIN correct_answers ON questions.id = correct_answers.question_id;";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $qa_list  = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = shuffle($qa_list);
        //テスト画面へ遷移
        if ($result === false) {
            //新規qa登録画面へ遷移
            header("location: register_form.php");
        }else{
            $_SESSION['qa_list'] = $qa_list;
            header("location: test_form.php");
        }
    }else if(isset($_POST["history"]))
    {
        //ログインユーザーのデータをhistoriesより取得する
        $sql = "SELECT * FROM histories WHERE user_id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        //該当する全件を取得
        //連想配列で取得
        $members  = $stmt->fetchAll(PDO::FETCH_ASSOC);        
        //履歴へ遷移
        $_SESSION['members'] = $members;
        header("location: history_form.php");
    }
}else
{
   $_SESSION['msg'] = "セッションが切れています。";
   header("location: login_form.php");
}
?>