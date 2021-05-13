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
    $sql = "SELECT questions.id as qid, questions.question as q , correct_answers.id as aid, correct_answers.answer as a FROM questions INNER JOIN correct_answers ON questions.id = correct_answers.question_id WHERE questions.id = :qid ORDER BY questions.id;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':qid', $id);
    $stmt->execute();
    //連想配列で取得
    $qa_array = $stmt->fetchAll(PDO::FETCH_ASSOC);     
    //収集したデータを表示用へカスタマイズする
    require('listCustom.php');
?>