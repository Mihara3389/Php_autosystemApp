<?php
session_start();
// エラーメッセージの初期化
$err_list = [];
//ログインセッションを確認
if (isset($_SESSION['id']))
 {
    //データベースへ接続
    require('dbconnect.php');
    //チェックボタンが押された場合
    if (isset($_POST["Delete"])) {
      //deleteするデータを取得する
      require('confirm.php');
      if (empty($qa_array)) {
        //新規qa登録画面へ遷移
        header("location: register_form.php");
      } else {
        //リスト画面へ遷移
        $_SESSION['list'] = $list;
        header("location: delete_form.php");
      }
    }else if(isset($_POST["Cheack"])){
      
    }
  }else{
        $_SESSION['msg'] = "セッションが切れています。";
        $err_list = $_SESSION;
        header("location: login_form.php");
}
?>