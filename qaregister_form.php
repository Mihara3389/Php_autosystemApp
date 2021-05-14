<?php
    session_start();
    $err_list = $_SESSION;
    unset($_SESSION['msg']);
    unset($_SESSION['msg_question']);
    unset($_SESSION['msg_answer']);
?>
<link  href="css/register.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="css/validationEngine.jquery.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="js/register.js"></script>
<script src="js/validation.js"></script>
<script src="js/jquery-1.8.2.min.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-ja.js"></script>
<title>Register</title>
<body>
<div class="box">
<form action="qaregister.php"  method="post">
<?php if(!empty($err_list['msg'])): ?>
    <p style="color:red;"><?php echo $err_list['msg']; ?></p>
<?php endif; ?>
    <div class="form">
        <a href="topIndex.php">top</a>
	    <a href="logout.php">logout</a>
    </div>
    <div id="form-name">
    <table id="tbl">
   	    <tr>	
   		    <td >問題：</td>
            <?php if(!empty($err_list['msg_question'])): ?>
                <p style="color:red;"><?php echo $err_list['msg_question']; ?></p>
            <?php endif; ?>
   		    <td><input type="text" id="question" name="question" placeholder="Question" class="validate[required,maxSize[500]]"></td>
   	    </tr>
   	    <tr>
  		    <td>答え：</td>
            <?php if(!empty($err_list['msg_answer'])): ?>
                <p style="color:red;"><?php echo $err_list['msg_answer']; ?></p>
            <?php endif; ?>
   		    <td><input type="text" id="answer" name="answer[]" placeholder="Answer"  class="validate[required,maxSize[255]]"></td>
   	    </tr>
    </table>
    </div>
    <br>
    <input type="submit" name="Return_list"  value="Return">
    <input type="submit" name="Cheack"  value="Cheack">
    <input type="button" name="Add" value="Add" onclick="appendRow()">
</form>
</div>
</body>