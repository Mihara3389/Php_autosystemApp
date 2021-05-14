<?php
//dbより取得した配列を取得
 $qalist = $qa_array;
 print_r($qalist);
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
         if (!isset($qa['aid'])) {
            $flg = 0;
            $count = 0;
            $add = array('flg'=>$flg, 'count'=>$count);
            $qa = array_merge($qa, $add);
            $list[] = $qa;
         }else{
             if (in_array($qid, $test_array, true)) {
                 $flg = 0;
                 $count = ++$count;
                 $add = array('flg'=>$flg, 'count'=>$count);
                 $qa = array_merge($qa, $add);
                 $list[] = $qa;
             } else {
                 $flg = 1;
                 $count = 1;
                 $test_array[] = $qid;
                 $add = array('flg'=>$flg, 'count'=>$count);
                 $qa = array_merge($qa, $add);
                 $list[] = $qa;
             }
         }
    }
 ?>