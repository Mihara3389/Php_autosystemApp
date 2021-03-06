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
</head>
<body>
<title>Registration_Form</title>
<div class ="box">
<form action="register.php" method="post" novalidate>
    <h1>Registration</h1>
    <?php if(!empty($err_list['msg'])): ?>
        <p style="color:red;"><?php echo $err_list['msg']; ?></p>
    <?php endif; ?>
    <div id="form-name">
        <input type="text"  name="username"  placeholder="Username" class="validate[required,maxSize[63]]">
        <?php if(!empty($err_list['msg_username'])): ?>
            <p><?php echo $err_list['msg_username']; ?></p>
        <?php endif; ?>
        <input type="password" name="password" placeholder="Password" class="validate[required,custom[password],maxSize[255]]">
        <?php if(!empty($err_list['msg_password'])): ?>
            <p><?php echo $err_list['msg_password']; ?></p>
        <?php endif; ?>
    </div>
    <input type="submit" id="Signup" name="Signup" value="Signup">
    <a href="login_form.php">キャンセル</a>
 </form>
</div>