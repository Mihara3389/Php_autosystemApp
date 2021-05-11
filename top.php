<?php
session_start();
// エラーメッセージの初期化
$err = [];
//変数初期化
$members =[];
$qadata = [];
$merge = [];
//ログインセッションを確認
if (isset($_SESSION['id']))
 {
    //データベースへ接続
    require('dbconnect.php');
    //セッションよりidとユーザー名を取得する
    $id = $_SESSION['id'];
    //フォームからの値をチェック
    if (isset($_POST["list"])) {
        //questionsとcorrect_answersよりデータを取得する
        $sql = "SELECT questions.id as qid, questions.question as q , correct_answers.id as aid, correct_answers.answer as a FROM questions INNER JOIN correct_answers ON questions.id = correct_answers.question_id ORDER BY questions.id;";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        //questions全件を取得
        //連想配列で取得
        while ($qa  = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $qadata[] = $qa;
        }
        //dbより取得した配列を取得
        $qalist = [];
        $qalist = $qadata;
        //以下結果を入れる変数・そのほか変数初期化
        $flg = 0;
        $count = 0;
        $list = [];
        $testbox = [];
        //取得idより質問にflg、答えにcountを入れるためサーチ
        foreach ($qalist as $v1) {
                //変数定義
                $ck = '';
                $v2 = '';
                $v2 = $v1['qid'];
                //配列のデータを比較する（第三引数は必須）
                if (in_array($v2, $testbox, true)) {
                    $flg = 0;
                    $count = ++$count;
                    $add = array('flg'=>$flg, 'count'=>$count);            
                    $v1 = array_merge($v1,$add);
                    $list[] = $v1;
                } else {
                    $flg = 1;
                    $count = 1;
                    $testbox[] = $v2;
                    $ck =  $v2;
                    $add = array('flg'=>$flg, 'count'=>$count);            
                    $v1 = array_merge($v1,$add);
                    $list[] = $v1;
            }
        }
        if (empty($qadata)) {
            //新規qa登録画面へ遷移
            header("location: register_form.php");
        } else {
            //リスト画面へ遷移
            $_SESSION['list'] = $list;
            header("location: list_form.php");
        }
    }else if(isset($_POST["test"]))
    {
        //テスト画面へ遷移
        header("location: test_form.php");
    }else if(isset($_POST["history"]))
    {
        //ログインユーザーのデータをhistoriesより取得する
        $sql = "SELECT * FROM histories WHERE user_id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        //該当する全件を取得
        //連想配列で取得
        while($member  = $stmt->fetch( PDO::FETCH_ASSOC )){
            $members[] = $member;
        }
        //履歴へ遷移
        $_SESSION['members'] = $members;
        header("location: history_form.php");
    }
}else
{
        $_SESSION['msg'] = "セッションが切れています。";
        $err = $_SESSION;
        header("location: login_form.php");
}
?>