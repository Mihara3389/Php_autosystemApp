<?php
    //画面より質問idを取得する
    $id = $_POST['id'];
    //問題idが取得できていなかったらエラー
    if (empty($id)) {
        $_SESSION['msg'] = "問題idが取得できませんでした。";
        if (isset($_POST["Delete"])) {
            header("location: delete_form.php");
        }else if (isset($_POST["Edit"])) {
            header("location: edit_form.php");
        }
    }
    //問題idより質問と答えを取得
    $sql = "SELECT questions.id as qid, questions.question as q , correct_answers.id as aid, correct_answers.answer as a FROM questions INNER JOIN correct_answers ON questions.id = correct_answers.question_id WHERE questions.id = :qid;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':qid', $id);
    $stmt->execute();
    //連想配列で取得
    $qa_list = $stmt->fetchAll(PDO::FETCH_ASSOC);  
    //問題idより質問と答えを取得
    $sql = "SELECT questions.id as qid, questions.question as q  FROM questions WHERE questions.id = :qid;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':qid', $id);
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
?>