<?php 
ob_start();
session_start(); 
?>

<!DOCTYPE html>

<head>
<title>Engineering Laboratory</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="add_edit_delete_style.css" rel="stylesheet" type="text/css">
</head>

<?php
    if(isset($_SESSION['name'])) 
    {
        $key_id = $_GET['key_id'];

        $conn = new mysqli("localhost","root","P@ssw0rd","laboratory_system");// Create connection
        if ($conn->connect_error){die("Connection failed: " . $conn->connect_error);}// Check connection

        $sql = "SELECT * FROM engineering_lab WHERE id = $key_id";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($result);
        mysqli_close($conn);
    }
    else    
    {
        echo "<h3>กระบวนการไม่ถูกต้อง</h3>";
        back();
    }
?>

<?php
if(isset($_POST['submit'])) 
    {

        $filename = $_POST['file'];
        $filepath = "./picture/" . $filename;

        unlink($filepath);

        $id = $_POST['id'];

        $conn = new mysqli("localhost","root","P@ssw0rd","laboratory_system");// Create connection
        if ($conn->connect_error){die("Connection failed: " . $conn->connect_error);}// Check connection

        $sql = "DELETE FROM engineering_lab WHERE id = $id";
        $delete = mysqli_query($conn , $sql);
        if(!$delete)
            {
                
                echo mysqli_error($conn);
                mysqli_close($conn);
            }
        else
            {
                
                $data = NULL;
                mysqli_close($conn);
                back();
            }
    }

?>

<?php
function back()
{
    header("refresh: 1.5; url=index.php");
}
?>

<fieldset><legend><h4 style="color:black;"><?php echo isset($data) ? "คุณต้องการลบข้อมูลต่อไปนี้ใช่หรือไม่?" : "ข้อมูลถูกลบแล้ว"; ?></h4></legend>

<form method="POST" enctype="multipart/form-data">

<input type="hidden" id="id" name="id" value="<?php echo $data['id'] ?? ''; ?>">

<label for="branch">สาขา:</label>
<select style="background-color: #e6e6e6;" id="branch" name="branch" readonly>
    <option value="<?php echo $data['branch'] ?? ''; ?>"><?php echo $data['branch'] ?? ''; ?></option>
</select><br>

<label for="room">ห้อง:</label>
<input style="background-color: #e6e6e6;" type="text" id="room" name="room" value="<?php echo $data['room'] ?? ''; ?>" readonly><br>

<label for="instrument">ชื่ออุปกรณ์:</label>
<input style="background-color: #e6e6e6;" type="text" id="instrument" name="instrument" value="<?php echo $data['instrument'] ?? ''; ?>" readonly><br>

<label for="quantity">จำนวน:</label>
<input style="background-color: #e6e6e6; width: 150px;" type="number" id="quantity" name="quantity" value="<?php echo $data['quantity'] ?? ''; ?>" readonly><br>

<label for="caretaker">ผู้ดูแล:</label>
<input style="background-color: #e6e6e6;" type="text" id="caretaker" name="caretaker" value="<?php echo $data['caretaker'] ?? ''; ?>" readonly><br>

<label for="file">รูปภาพ:</label>
&nbsp;<img src="<?php echo isset($data['image']) ? '../picture/'.$data['image'] : ''; ?>" width="200" style="display: inline-block; vertical-align: top;"><br><br>
<input type="hidden" id="file" name="file" value="<?php echo $data['image'] ?? ''; ?>" readonly>

    
    
    <?php
        if (isset($data))
        {
            echo '<div class="button"><button type="submit" value="Submit" name="submit">ลบข้อมูล</button>&nbsp;&nbsp;<a class="back" href="index.php">ย้อนกลับ</a></div>';
        }
        else
        {
            echo "<br>";
        }
    ?>

</form> 
</fieldset>

</body>
</html>