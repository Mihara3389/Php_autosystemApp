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
    if (isset($_POST["Cheack"])) {
        //セッションよりユーザー名を取得
        $username = $_SESSION['name'];
        //入力値を取得
        $id_list = $_POST['id'];
        $answer_list = $_POST['answer'];
        //idが取得できていなかったらエラー
        if (empty($id_list)) {
            $_SESSION['msg'] = "問題idが取得できませんでした。";
            header("location: test_resultform.php");
        }
        //現在時刻を取得
        date_default_timezone_set('Asia/Tokyo');
        $now = date("Y/m/d G:i:s");
        //idに紐づく答えを全件取得
        //答えの照合に必要な分だけ取得
        $all_count = 0;
        $answer_count = 0;
        $correct_count = 0;
        foreach ($id_list as $id) {
            //問題数カウント
            $all_count = $all_count + 1;
            $dbanswer_array = [];
            $sql = "SELECT question_id,answer FROM correct_answers WHERE question_id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $dbanswer_array  = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //データベースで取得した値を配列へ変換
            $dbanswer_list = $dbanswer_array;
            //入力値の分ループ
            foreach ($answer_list as $answer) {
                //dbの配列分ループ
                foreach ($dbanswer_list as $dbanswer) {
                //配列の中から探索
                    if (in_array($answer, $dbanswer, true)) {
                    $answer_count = $answer_count + 1;
                    $correct_count = $correct_count + 1;
                    }      
                }
            }
        }
        //採点
        $result_point = round(($correct_count / $all_count)*100);
        //insert
        $sql = "INSERT INTO histories(user_id, point, created_at) VALUES (:user_id, :point, :created_at)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $_SESSION['id']);
        $stmt->bindValue(':point', $result_point);
        $stmt->bindValue(':created_at', $now);
        $stmt->execute();
        //採点結果
        $_SESSION['all_count'] = $all_count;
        $_SESSION['answer_count'] = $answer_count;
        $_SESSION['result_point'] = $result_point;
        $_SESSION['current_time'] = $now;
        //テスト結果画面へ遷移
        header("location: test_resultform.php");
    }
}else
{
        $_SESSION['msg'] = "セッションが切れています。";
        header("location: login_form.php");
}
?>