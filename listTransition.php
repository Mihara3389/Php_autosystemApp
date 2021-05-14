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
      require('listRelation.php');
      if (empty($qa_array)) {
        //新規qa登録画面へ遷移
        header("location: qaregister_form.php");
      } else {
        //削除確認画面へ遷移
        $_SESSION['list'] = $list;
        header("location: delete_form.php");
      }
    }else if(isset($_POST['Edit'])){
      //editするデータを取得する
      require('listRelation.php');
      if (empty($qa_array)) {
        //新規qa登録画面へ遷移
        header("location: qaregister_form.php");
      } else {
        //編集確認画面へ遷移
        $_SESSION['list'] = $list;
        header("location: edit_form.php");
      }
    }else if(isset($_POST['Register'])){
        //register_formへ遷移
        header('location: qaregister_form.php');
    }else if(isset($_POST["Return"])){
      //リスト画面へ戻る
      require('listGather.php');   
    }
  }else{
        $_SESSION['msg'] = "セッションが切れています。";
        header("location: login_form.php");
}
?>