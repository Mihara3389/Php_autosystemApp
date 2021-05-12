<?php
session_start();
// エラーメッセージの初期化
$err = [];
//変数初期化
$id = [];
$answer = [];
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
        $id = $_POST['id'];
        $answer = $_POST['answer'];
        //idが取得できていなかったらエラー
        if (empty($id)) {
            $_SESSION['msg'] = "問題がありません。登録してください。";
            $err = $_SESSION;
            header("location: login_form.php");
        }
        //現在時刻を取得
        date_default_timezone_set('Asia/Tokyo');
        $now = date("Y/m/d G:i:s");
        //idに紐づく答えを全件取得
        //答えの照合に必要な分だけ取得
        $all_count = 0;
        $answer_count = 0;
        $correct_count = 0;
        foreach ($id as $i) {
            //問題数カウント
            $all_count = $all_count + 1;
            $id_answers = [];
            $sql = "SELECT question_id,answer FROM correct_answers WHERE question_id = :i";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':i', $i);
            $stmt->execute();
            while ($id_answer  = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id_answers[] = $id_answer;
            }
            //データベースで取得した値を配列へ変換
            $dbanswer = [];
            $dbanswer = $id_answers;
            //入力値の分ループ
            foreach ($answer as $v1) {
                //dbの配列分ループ
                foreach ($dbanswer as $v2) {
                //配列の中から探索
                    if (in_array($v1, $v2, true)) {
                    $answer_count = $answer_count + 1;
                    $correct_count = $correct_count + 1;
                    }      
                }
            }
        }
        //採点
        $cheack = 0;
        $result_point = 0;
        $cheack = ($correct_count / $all_count)*100;
        $result_point = round($cheack);
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
        $err = $_SESSION;
        header("location: login_form.php");
}
?>