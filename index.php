<?php
session_start(); 
?>

<!DOCTYPE html>

<head>
<title>Engineering Laboratory</title>
<meta charset="utf-8">
<link href="index_style.css" rel="stylesheet" type="text/css">
</head>

<body class="for_index.php">

<p>ทดสอบ Run เว็บแอปพลิเคชั่น บน <img src="./picture/windows.png" width="30px"> Windows Server 2019 โยใช้ Web Server เป็น IIS และ Database sever เป็น MySql</p>

<div class="header">

    <div class="header-one"><img src="universitylogo.png" alt="universitylogo" width="30" height="52"></div>
    <div class="header-two"><a class="header">ระบบข้อมูลห้องปฏิบัติการคณะวิศวกรรมศาสตร์ (Engineering Laboratory)</a><br/></div>
    
    <div class="login">

        <?php 
            if(!isset($_SESSION['name']))  /*ไม่ได้ล็อคอิน*/
            {
                echo "<a class='notlogin' href='login.php'>Login</a>";
            }
            else/*ล็อคอินแล้ว*/
            {
                echo "<a class='logined'  href='logout.php'>Logout</a>";
                echo "<br/>";
                echo "<a href='add.php'>เพิ่มข้อมูล</a>";

            }
        ?>

    </div>
</div>

<div class="body">
    <div class="body-one" id="myButton">
        <button class="btnA active" type="button" value="all">ทั้งหมด</button><br/>
        <button class="btn" type="button" value="โยธา">วิศวกรรมโยธา</button><br/>
        <button class="btn" type="button" value="ไฟฟ้า">วิศวกรรมไฟฟ้า</button><br/>
        <button class="btn" type="button" value="เครื่องกล">วิศวกรรมเครื่องกล</button><br/>
        <button class="btn" type="button" value="อุตสาหการ">วิศวกรรมอุตสาหการ</button><br/>
        <button class="btn" type="button" value="คอมพิวเตอร์">วิศวกรรมคอมพิวเตอร์</button><br/>
    </div>
    

    <div class="body-two">
        <a class="data" id="data"></a>
    </div>

</div>

<script src="javascript.js"></script>
</body>


</html>