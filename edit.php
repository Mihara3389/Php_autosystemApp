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
  if(isset($_POST['Cheack'])){
    //バリデーションチェック
    if (empty($_POST['question'])) {  // 値が空のとき
      $_SESSION['msg_question'] = "質問が未入力です。";
      $err_list = $_SESSION;
    } elseif (empty($_POST['answer'])) {// 値が空のとき
      $_SESSION['msg_answer'] = "答えが未入力です。";
      $err_list = $_SESSION;
    }elseif (!empty($_POST['question']) && !empty($_POST['answer'])) {
      //入力値を取得する
      $qid = $_POST['id'];
      $question = $_POST['question'];
      $aid_array = $_POST['answer_id'];
      $answer_array = $_POST['answer'];
      //答えの空白&重複チェック
      for($i = 0; $i < count($aid_array); ++$i){
        for($j = 0; $j < count($aid_array); ++$j){
          if ($i === $j) {  
            if(!empty($answer_array[$j])){
              if($bf === $answer_array[$j]){
                $_SESSION['msg'] = "答えが重複しています。";
                $err_list = $_SESSION;
              }else{
                $aid_list[] = $aid_array[$i];
                $answer_list[] = $answer_array[$j];
                $bf = $answer_array[$j];
              }
            }
          }   
        }
      }
      //取得したデータをセッションへ格納
      if (count($err_list) > 0) {
        //edit_formへ遷移
        header('location: edit_form.php');
        return;
      } else {
        $_SESSION['qid'] = $qid;
        $_SESSION['question'] = $question;
        $_SESSION['aid_list'] = $aid_list;
        $_SESSION['answer_list'] = $answer_list;
        //編集確認画面へ遷移
        header("location: editConfirm_form.php");
      }
    }
    if (count($err_list) > 0) {
      //edit_formへ遷移
      header('location: edit_form.php');
      return;
    }
  }else if(isset($_POST['Update'])){
    //入力値を取得する
    $qid = $_POST['id'];
    $question = $_POST['question'];
    $aid_array = $_POST['answer_id'];
    $answer_array = $_POST['answer'];
    //データベース接続処理
    require('dbconnect.php');
    //現在時刻を取得
    date_default_timezone_set('Asia/Tokyo');
    $now = date("Y/m/d G:i:s");
    //問題のupdate
    $sql = "UPDATE questions SET question = :question, updated_at = :updated_at WHERE id = :id;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':question', $question);
    $stmt->bindValue(':updated_at', $now);
    $stmt->bindValue(':id', $qid);
    $stmt->execute();
    //答えのupdate
    if(empty($answer_array)){
      $_SESSION['msg'] = "答えがありません。";
      require('edit_form.php');
    }else{
        //問題idに一致する答えを全件取得する
        $sql = "SELECT id FROM correct_answers where question_id = :question_id;";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':question_id', $qid);
        $stmt->execute();
        //配列で受け取るためにループで回す
        while($all_array = $stmt->fetch(PDO::FETCH_ASSOC)){
          $all_list[] = $all_array['id'];
        }
        //配列へ変換
        $aid_list = $aid_array;
        //更新対象に値しない答えを削除
        for ($i = 0; $i < count($all_list); ++$i) {
            //削除フラグ
            $delete_flg = 0;
            $add_flg = 0;
            $all = $all_list[$i];
            for ($j = 0; $j < count($aid_list); ++$j) {
                $aid = $aid_list[$j];
                if ( $all === $aid or $aid === 'new') {
                    $delete_flg = 1;
                    break;
                }
            }
            if ($delete_flg === 0) {
                $sql = "DELETE FROM correct_answers WHERE id = :aid;";
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':aid', $all);
                $stmt->execute();
            }
        }
        //答えを更新・追加する
        for ($k = 0; $k < count($aid_list); ++$k) {
          //配列へ変換
          $answer_list = $answer_array;
          for ($l = 0; $l < count($answer_list); ++$l) {
            if($k === $l){
              if(($aid_array[$k])==='new'){
                $sql = "INSERT INTO correct_answers(question_id, answer,created_at, updated_at) VALUES (:question_id, :answer, :created_at, :updated_at)";
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':question_id', $qid);
                $stmt->bindValue(':answer', $answer_list[$l]);
                $stmt->bindValue(':created_at', $now);
                $stmt->bindValue(':updated_at', $now);
                $stmt->execute();      
              }else{
                $sql = "UPDATE correct_answers SET answer = :answer, updated_at = :updated_at WHERE id = :id and question_id = :question_id;";
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':id', $aid_array[$k]);
                $stmt->bindValue(':question_id', $qid);
                $stmt->bindValue(':answer', $answer_list[$l]);
                $stmt->bindValue(':updated_at', $now);
                $stmt->execute();      
              }
            }
          }
        }
    }
    //リストへ戻る
    require('listGather.php');
  }else if(isset($_POST["Return_list"])){
    //リスト画面へ戻る
    require('listGather.php');   
  }else if(isset($_POST["Return_edit"])){
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
  }
}else{
  $_SESSION['msg'] = "セッションが切れています。";
  header("location: login_form.php");
}
?>