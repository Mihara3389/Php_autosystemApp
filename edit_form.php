<?php
    session_start();
    $list = $_SESSION['list'];
?>
<link  href="css/list.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="css/validationEngine.jquery.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="js/register.js"></script>
<script src="js/validation.js"></script>
<script src="js/jquery-1.8.2.min.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-ja.js"></script>
<title>Edit_Confirm</title>
<body>
<form class="box" action="edit.php" method="post">
<div class="form">
    <a href="index.php">top</a>
    <a href="logout.php">logout</a>
</div>
<?php if(!empty($list)): ?>
	<div id="form-name">
    <table id="tbl">
		<tbody>
		<?php foreach($list as $l){?> 
	    <?php if($l['flg'] === 1): ?>
	    	<tr>
            	<td> 問題：</td>
		    	<td><input type="hidden"  id="id" name="id"  value=<?php echo $l['qid']; ?>>
		        	<input type="text"  id="question" name="question"  value=<?php echo $l['q']; ?> class="validate[required,maxSize[500]]"></td>
    		</tr>
		<?php endif; ?>
		<?php } ?>
		</tbody>
		<tbody>
		<?php foreach($list as $l){?> 
   	    <tr>
            <?php if($l['flg'] === 1): ?>
   		        <td> 答え：</td>
				<td><input type="text" id="answer" name="answer[]"  value=<?php echo $l['a']; ?> class="validate[required,maxSize[255]]"></td>   
            <?php else: ?>
                <td>&emsp;&emsp;&emsp;</td>
				<td><input type="text" id="answer" name="answer[]"  value=<?php echo $l['a']; ?> class="validate[required]"></td>   
            <?php endif; ?>
        </tr>
		<?php } ?>
		</tbody>
    </table>
	</div>
<?php endif; ?>
<br>
<input type="submit" name="Return"  value="Return">
<input type="submit" name="Cheack"  value="Cheack">
<input type="button" name="Add" value="Add" onclick="appendRow()">
<br />
</form>
</body>