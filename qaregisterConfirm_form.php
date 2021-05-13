<?php
    session_start();    
    $err_list = $_SESSION;
    unset($_SESSION['msg']);
    $question = $_SESSION['question'];
    $answer_list = $_SESSION['answer_list'];
?>
<link  href="css/register.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<title>RegistConfirm</title>
<?php if(!empty($err_list['msg'])): ?>
        <p style="color:red;"><?php echo $err_list['msg']; ?></p>
<?php endif; ?>
<body>
<form class="box" action="qaregister.php"  method="post">
<div class="form">
        <a href="topIndex.php">top</a>
	    <a href="logout.php">logout</a>
</div>
<table>
    <tbody>
	    <tr>
            <td> 問題：</td>
            <?php if(!empty($question)): ?>
                <td><input type="text"  id="question" name="question"  value=<?php echo $question; ?>  readonly></td>
            <?php endif; ?>   	            
        </tr>
    </tbody>
    <?php if(!empty($answer_list)): ?>
    <?php for($i = 0; $i < count($answer_list); ++$i){?>     
    <tbody>
        <tr>
            <td> 答え：</td>
                <td><input type="text" id="answer" name="answer[]"  value=<?php echo $answer_list[$i]; ?>  readonly></td>
        </tr>
    </tbody>
    <?php } ?>
    <?php endif; ?>   	            
</table>
<br>
<input type="submit" name="Return_register" value="Return">
<input type="submit" name="Register" value="Register">
</form>
</body>