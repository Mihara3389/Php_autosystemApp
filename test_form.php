<?php
    session_start();
    $testlist = $_SESSION['testlist'];
?>
<link  href="css/test_form.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<title>Test_Form</title>
<body>
<form class="box" action="test.php"  method="post">
    <div class="form">
        <a href="index.php">top</a>
	    <a href="logout.php">logout</a>
    </div>
    <table>
        <?php foreach($testlist as $tl){?>
        <tr>
    	    <td><input type="text"  id="id" name="id[]"  value=<?php echo $tl['qid']; ?> readonly></td>
		    <td><input type="text"  id="question" name="question[]"  value=<?php echo $tl['q']; ?>  readonly></td>
	    </tr>
        <tr>
            <td> 回答：</td>
            <td><input type="text" id="answer" name="answer[]" placeholder="Answer"></td>
     	</tr>
        <?php } ?>
	</table>
	<br>
    <input type="submit" id="Cheack" name="Cheack" value="Cheack">
</form>
</body>