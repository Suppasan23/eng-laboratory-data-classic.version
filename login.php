<?php 
ob_start();
session_start(); 
$err = ''; // Initialize the $err variable
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<meta charset="utf-8">
</head>

<body>

<?php
if($_POST) 
{

    $username = $_POST['input_user'];
	$password = $_POST['input_pswd'];

    $conn = new mysqli("localhost","root","P@ssw0rd","laboratory_system");

    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the entered credentials match with any row in the "admin" table
    $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['name'] = true;
    } else {
        $err  = '<span>ชื่อผู้ใช้ หรือรหัสผ่านไม่ถูกต้อง</span>';
    }
    
    $conn->close();
}
?>

<?php 
	if(!isset($_SESSION['name'])) {
?>

    <div align = "center">
    <div style = "width:420px; height:230px; border: solid 1px #000000; background: #f2f2f2; border-radius: 4px; " align = "Right">
    <div style = "background-color:#000000; color:#FFFFFF; padding:8px;" align = "Left"><b style = "font-size:18px;">เข้าสู่ระบบ</b></div>
	<div align = "right" style = "margin-top: 3px;"><a style = "font-size:26px; margin-right: 45px; ">โปรดใส่รหัสผู้ดูแลระบบ</a></div><br/>
   
    <div align = "right" style = "margin-right: 45px;">
	<form method="post">
		
  		<label style = "font-size:20px;">User :</label>  <input style = "font-size:20px;" type="text" name="input_user" required><br/><p style="margin: 2px;"></p>
    	<label style = "font-size:20px;">Password :</label>  <input style = "font-size:20px;" type="password" name="input_pswd" required><br><br>
    	<button style = "width:65px; height:38px; font-size:20px;">Login</button>
		&nbsp;
			
		<?php 
		 echo "<a  href='index.php' style = 'font-size:20px;'>Back</a>";
		?>
		
    </form>
                
            <div style = "font-size:15px; color:#cc0000; margin-top:10px"><?php echo $err; ?></div>
        </div>
    </div>
</div>

<?php
 	} else {
?>
	    <div align="center"><h3 style="color:green">ท่านได้เข้าสู่ระบบแล้ว จะกลับสู่หน้าหลักใน 1 วินาที</h3><div>
		<?php 
			header("refresh:1.5;url=index.php");  
		?>
<?php
	}
?>
	
</body>
</html>
