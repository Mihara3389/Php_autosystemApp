<?php
    session_start();    
	$err_list = $_SESSION;
    $username = $_SESSION['name'];
  	$all_count = $_SESSION['all_count'];
	$answer_count = $_SESSION['answer_count'];
    $result_point = $_SESSION['result_point'];
    $now = $_SESSION['current_time'];
?>
<link  href="css/test.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<title>Test_Form</title>
<?php if(!empty($err_list['msg'])): ?>
        <p style="color:red;"><?php echo $err_list['msg']; ?></p>
<?php endif; ?>
<body>
<form class="box" action="test.php"  method="post">
    <div class="form">
        <a href="index.php">top</a>
	    <a href="logout.php">logout</a>
    </div>
	<h1>テスト結果</h1>
	<table style="color: white;">
    	<tr>
    	 <td><?php echo $username; ?>さん</td>
    	</tr>
    	<tr>
    	 <td><?php echo $all_count; ?>問中<?php echo $answer_count; ?>問正解です。</td>
    	</tr>
    	<tr>
   	     <td><?php echo $result_point; ?>点でした。</td>
   	    </tr>
   	</table>
   	<div class="form">
   	     <div><?php echo $now; ?></div>
	</div>
</div>
</body>
</html>