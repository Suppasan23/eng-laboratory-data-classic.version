<?php
session_start();
session_destroy();


header("refresh: 1.5; url=index.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
	
<style>
	body 
    {
		cursor: wait;
		text-align: center;
	}
</style>
	
<title>Logout</title>
</head>

<body>
	<h3 style="color:red">ท่านได้ออกจากระบบแล้ว จะกลับสู่หน้าหลักใน 1 วินาที</h3>
</body>

</html>