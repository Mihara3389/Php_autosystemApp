<?php
    session_start();    
    $err_list = $_SESSION;
    unset($_SESSION['msg']);
    $qid = $_SESSION['qid'];
    $question = $_SESSION['question'];
    $aid_list = $_SESSION['aid_list'];
    $answer_list = $_SESSION['answer_list'];
?>
<link  href="css/register.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<title>Edit_Confirm</title>
<?php if(!empty($err_list['msg'])): ?>
    <p style="color:red;"><?php echo $err_list['msg']; ?></p>
<?php endif; ?>
<body>
<form class="box" action="edit.php"  method="post">
<div class="form">
    <a href="topIndex.php">top</a>
	<a href="logout.php">logout</a>
</div>
<table>
    <tbody>
    <tr>
        <td> 問題：</td>
        <?php if(!empty($question)): ?>
            <td><input type="text"  id="question" name="question"  value=<?php echo $question; ?>  readonly>
                <input type="hidden"  id="id" name="id"  value=<?php echo $qid; ?>></td>
        <?php endif; ?>   	            
    </tr>
    </tbody>
    <tbody>
    <?php if(!empty($aid_list) and !empty($answer_list)): ?>
    <tr>
        <?php for($i = 0; $i < count($aid_list); ++$i){?>
            <?php if($i === 0): ?>
                <td> 答え：</td>
            <?php endif; ?>   	                 
            <input type="hidden" id="answer_id" name="answer_id[]"  value=<?php echo $aid_list[$i]; ?>>
        <?php } ?>
        <td>
        <?php for($j = 0; $j < count($answer_list); ++$j){?>    
            <input type="text" id="answer" name="answer[]"  value=<?php echo $answer_list[$j]; ?>  readonly>
        <?php } ?>
        </td>
    </tr>
    <?php endif; ?>   	            
    </tbody>
</table>
<br>
<input type="submit" name="Return_edit" value="Return">
<input type="submit" name="Update" value="Update">
</form>
</body>