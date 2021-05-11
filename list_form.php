<?php
    session_start();
	$list = $_SESSION['list'];
	$_SESSION = array();
    session_destroy();
?>
<link  href="css/list.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<title>List</title>
<body>
<div class="box" >
<form action="list.php" method="post">
<div class="form">
        <a href="index.php">top</a>
	    <a href="logout.php">logout</a>
</div>
<input type="submit" name="register" value="register">
</form>
<?php if(!empty($list)): ?>
<?php foreach($list as $l){?>  
<table>
	<?php if($l['flg'] === 1): ?>
	<tr>
        <td> 問題：</td>
		<td><input type="text"  id="id" name="id"  value=<?php echo $l['qid']; ?> readonly></td>
		<td><input type="text"  id="question" name="question"  value=<?php echo $l['q']; ?>  readonly></td>
		<td>
		<form action="list.php" method="post">		
		    <input type="submit" name="edit" value="edit">
		    <input type="hidden" name="id" value=<?php echo $l['qid']; ?>>
		</form>
		</td>
   		<td>
   		<form action="list.php" method="post">		
		    <input type="submit" name="delete" value="delete">
		    <input type="hidden" name="id" value="<?php echo $l['qid']; ?>">
		</form>
		</td>
	</tr>
	<?php endif; ?>
   	<tr>
   		<td> 答え：</td>
   		<td ><input type="text" id="answer_id" name="answer_id"  value=<?php echo $l['count']; ?>  readonly></td>
        <td><input type="text" id="answer" name="answer"  value=<?php echo $l['a']; ?>  readonly></td>
		<td></td>
		<td></td>
	</tr>
</table>
<?php } ?>
<?php endif; ?>
</div>
</body>