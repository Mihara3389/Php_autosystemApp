<?php
    session_start();
    $list = $_SESSION['list'];
?>
<link  href="css/list.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<title>Delete_Confirm</title>
<body>
<form class="box" action="delete.php"  method="post">
<div class="form">
    <a href="topIndex.php">top</a>
    <a href="logout.php">logout</a>
</div>
<?php if(!empty($list)): ?>
    <?php foreach($list as $l){?> 
    <table>
	    <?php if($l['flg'] === 1): ?>
	    <tr>
            <td> 問題：</td>
		    <td><input type="hidden"  id="id" name="id"  value=<?php echo $l['qid']; ?> readonly>
		        <input type="text"  id="question" name="question"  value=<?php echo $l['q']; ?>  readonly></td>
    	</tr>
	    <?php endif; ?>
   	    <tr>
        <?php if(!empty($l['a'])): ?> 
            <?php if($l['flg'] === 1): ?>
   		        <td> 答え：</td>
            <?php else: ?>
                <td>&emsp;&emsp;&emsp;</td>
            <?php endif; ?>
                <td><input type="text" id="answer" name="answer"  value=<?php echo $l['a']; ?>  readonly></td>
        <?php endif; ?>
        </tr>
    </table>
    <?php } ?>
<?php endif; ?>
<br>
<input type="submit" name="Return" value="Return">
<input type="submit" name="Delete" value="Delete">  
<br />
</form>
</body>