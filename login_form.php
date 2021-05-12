<?php
    session_start();
    $err_list = $_SESSION;
    $_SESSION = array();
    session_destroy();
?>
<link  href="css/login.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="css/validationEngine.jquery.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="js/validation.js"></script>
<script src="js/jquery-1.8.2.min.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-ja.js"></script>
<body>
<title>Login_Form</title>
<div class="box">
<form id="form-name" action="login.php" method="post">
    <h1>Login</h1>
    <?php if(!empty($err_list['msg'])): ?>
        <p style="color:red;"><?php echo $err_list['msg']; ?></p>
    <?php endif; ?>
　  <input type="text" name="username" placeholder="Username" class="validate[required]">
    <input type="password" name="password"  placeholder="Password" class="validate[required]">
    <input type="submit" id="Login" name="Login" value="Login">
	<a href="signup.php">新規登録はこちら</a>
</form>
</div>
</body>