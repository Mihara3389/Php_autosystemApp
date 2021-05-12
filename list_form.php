<?php
    session_start();
	$list = $_SESSION['list'];
?>
<link  href="css/list.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<title>List</title>
<body>
<div class="box" >
<div class="form">
        <a href="index.php">top</a>
	    <a href="logout.php">logout</a>
</div>
<form action="register_form.php" method="post">
	<input type="submit" name="Register" value="Register">
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
		<form action="cheack.php" method="post">		
		    <input type="submit" name="Edit" value="Edit">
		    <input type="hidden" name="id" value=<?php echo $l['qid']; ?>>
		</form>
		</td>
   		<td>
   		<form action="cheack.php" method="post">		
		    <input type="submit" name="Delete" value="Delete">
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