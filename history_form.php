<?php
    session_start();
    $name = $_SESSION['name'];
    $members = $_SESSION['members'];
?>
<link  href="css/history.css" rel="stylesheet">
<link  href="css/style.css" rel="stylesheet">
<title>Result_History</title>
<body>
<body>
<form class="box" action=""  method="post">
    <div class="form">
        <a href="topIndex.php">top</a>
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
            <td style="text-align: center;"><?php echo $name; ?></td>
            <td style="text-align: center;"><?php echo $member['point']; ?></td>
            <td style="text-align: center;"><?php echo $member['created_at']; ?></td>
        </tr>
        </tbody>
<?php
}
?>
</table>
</form>
</body>