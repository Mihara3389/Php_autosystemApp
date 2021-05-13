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
    }else if(isset($_POST['Cheack'])){
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
            header('location: register_form.php');
            return;
          } else {
            $_SESSION['question'] = $question;
            $_SESSION['answer_list'] = $answer_list;
            //新規登録確認画面へ遷移
            header("location: register_cheackform.php");
          }
      }
      if (count($err_list) > 0) {
          //register_formへ遷移
          header('location: register_form.php');
          return;
      }
    }else if(isset($_POST["Return"])){
      //リスト画面へ戻る
      require('list.php');   
    }
  }else{
        $_SESSION['msg'] = "セッションが切れています。";
        header("location: login_form.php");
}
?>