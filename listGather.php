<?php    
 //questionsとcorrect_answersよりデータを取得する
 $sql = "SELECT questions.id as qid, questions.question as q , correct_answers.id as aid, correct_answers.answer as a FROM questions INNER JOIN correct_answers ON questions.id = correct_answers.question_id ORDER BY questions.id;";
 $stmt = $dbh->prepare($sql);
 $stmt->execute();
 //連想配列で取得
 $qa_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
 //questions全件を取得
 $sql = "SELECT id as qid, question as q FROM questions ORDER BY id;";
 $stmt = $dbh->prepare($sql);
 $stmt->execute();
 //連想配列で取得
 $q_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
 //questions全件とidが一致するqa全件との差分を取得
 $array = array_diff_key($q_array,$qa_list);
 //差分の問題とidが一致するqa全件をマージ
 $merges = array_merge($qa_list,$array);
 //多次元連想配列のソート
 foreach($merges as $key => $value){
    $sort[$key] = $value['qid'];
 }
 array_multisort($sort, SORT_ASC, $merges);
 $qa_array = $merges;
 //収集したデータを表示用へカスタマイズする
 require('listCustom.php');
 if (empty($qa_array)) {
    //新規qa登録画面へ遷移
    header("location: register_form.php");
 } else {
    //リスト画面へ遷移
    $_SESSION['list'] = $list;
    header("location: list_form.php");
 }
?>