<?php    
 //questionsとcorrect_answersよりデータを取得する
 $sql = "SELECT questions.id as qid, questions.question as q , correct_answers.id as aid, correct_answers.answer as a FROM questions INNER JOIN correct_answers ON questions.id = correct_answers.question_id ORDER BY questions.id;";
 $stmt = $dbh->prepare($sql);
 $stmt->execute();
 //questions全件を取得
 //連想配列で取得
 $qa_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
 //収集したデータを表示用へカスタマイズする
 require('list_custom.php');
 if (empty($qa_array)) {
     //新規qa登録画面へ遷移
     header("location: register_form.php");
 } else {
     //リスト画面へ遷移
     $_SESSION['list'] = $list;
     header("location: list_form.php");
 }
?>