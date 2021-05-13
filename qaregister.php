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
          $question = $_POST['question'];
          $answer_array = $_POST['answer'];
          //フォームに入力されたquestionがすでに登録されていないかチェック
          $sql = "SELECT question FROM questions WHERE question = :question";
          $stmt = $dbh->prepare($sql);
          $stmt->bindValue(':question', $question);
          $stmt->execute();
          //usernameに一致するものを1行取得
          $member = $stmt->fetchColumn();
          $key = strcmp($member, $question);
          if ($key === 0) {
            $_SESSION['msg'] = "入力された質問はすでに登録済です。";
            $err_list = $_SESSION;
          }
          //答えの空白&重複チェック
          foreach($answer_array as $answer){
            if(!empty($answer)){
              if($bf === $answer){
                $_SESSION['msg'] = "答えが重複しています。";
                $err_list = $_SESSION;
              }else{
                $answer_list[] = $answer;
                $bf = $answer;
              }
            }
          }
          //取得したデータをセッションへ格納
          if (count($err_list) > 0) {
            //register_formへ遷移
            header('location: qaregister_form.php');
            return;
          } else {
            $_SESSION['question'] = $question;
            $_SESSION['answer_list'] = $answer_list;
            //新規登録確認画面へ遷移
            header("location: qaregisterConfirm_form.php");
          }
      }
      if (count($err_list) > 0) {
          //register_formへ遷移
          header('location: qaregister_form.php');
          return;
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
        require('listGather.php');
    }elseif(isset($_POST["Return_register"])){
        //リストへ戻る
        require('qaregister_form.php');
    }else if(isset($_POST["Return_list"])){
        //リスト画面へ戻る
        require('listGather.php');   
    }
  }else{
        $_SESSION['msg'] = "セッションが切れています。";
        header("location: login_form.php");
}
?>