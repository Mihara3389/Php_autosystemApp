<?php
session_start();
// エラーメッセージの初期化
$err = [];
//変数初期化
$members =[];
//ログインセッションを確認
if (isset($_SESSION['id']))
 {
    //フォームからの値をチェック
    if (isset($_POST["list"])) 
    {
        header("location: list_form.php");
    }else if(isset($_POST["test"]))
    {
        header("location: test_form.php");
    }else if(isset($_POST["history"]))
    {
        //データベースへ接続
        require('dbconnect.php');
        //セッションよりidとユーザー名を取得する
        $id = $_SESSION['id'];
        //ログインユーザーのデータをhistoriesより取得する
        $sql = "SELECT * FROM histories WHERE user_id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        //該当する全件を取得
        //連想配列で取得
        while($member  = $stmt->fetch( PDO::FETCH_ASSOC )){
            $members[] = $member;
        }
        //履歴へ遷移
        $_SESSION['members'] = $members;
        header("location: history_form.php");
    }
}else
{
        $_SESSION['msg'] = "セッションが切れています。";
        $err = $_SESSION;
        header("location: login_form.php");
}
?>