<?php    
 //questionsとcorrect_answersよりデータを取得する
 $sql = "SELECT questions.id as qid, questions.question as q , correct_answers.id as aid, correct_answers.answer as a FROM questions INNER JOIN correct_answers ON questions.id = correct_answers.question_id ORDER BY questions.id;";
 $stmt = $dbh->prepare($sql);
 $stmt->execute();
 //questions全件を取得
 //連想配列で取得
 while ($qadata  = $stmt->fetch(PDO::FETCH_ASSOC)) {
     $qa_array[] = $qadata;
 }
 //dbより取得した配列を取得
 $qalist = $qa_array;
 //以下結果を入れる変数・そのほか変数初期化
 $flg = 0;
 $count = 0;
 $list = [];
 $test_array = [];
 //取得idより質問にflg、答えにcountを入れるためサーチ
 foreach ($qalist as $qa) {
         //変数定義
         $qid = $qa['qid'];
         //配列のデータを比較する（第三引数は必須）
         if (in_array($qid, $test_array, true)) {
             $flg = 0;
             $count = ++$count;
             $add = array('flg'=>$flg, 'count'=>$count);            
             $qa = array_merge($qa,$add);
             $list[] = $qa;
         } else {
             $flg = 1;
             $count = 1;
             $test_array[] = $qid;
             $add = array('flg'=>$flg, 'count'=>$count);            
             $qa = array_merge($qa,$add);
             $list[] = $qa;
     }
 }
 if (empty($qa_array)) {
     //新規qa登録画面へ遷移
     header("location: register_form.php");
 } else {
     //リスト画面へ遷移
     $_SESSION['list'] = $list;
     header("location: list_form.php");
 }
?>