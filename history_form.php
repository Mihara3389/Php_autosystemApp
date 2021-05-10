<?php
    session_start();
    $name = $_SESSION['name'];
    $members = $_SESSION['members'];
    $_SESSION = array();
    session_destroy();
?>
<link  href="css/history.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<title>Result_History</title>
<body>
<body>
<form class="box" action=""  method="post">
    <div class="form">
        <a href="index.php">top</a>
	    <a href="logout.php">logout</a>
    </div>
	<h1>履歴</h1>
    <table>
        <thead>
        <tr>
            <th>氏名</th>
            <th>採点</th>
            <th>採点時間</th>
        </tr>
        </thead>
        <?php foreach($members as $member){?>
        <tbody>
        <tr>
            <td><?php echo $name; ?></td>
            <td><?php echo $member['point']; ?></td>
            <td><?php echo $member['created_at']; ?></td>
        </tbody>
        </tr>
<?php
}
?>
</table>
</form>
</body>