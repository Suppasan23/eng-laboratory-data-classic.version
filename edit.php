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

    $file = $_FILES['new_pic'];
    // New file properties
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    //Old file properties
    $old_file_name = $_POST['old_pic'];

    if(!empty($file_name))
    {

        // get file extension
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        // allowed extensions
        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');

        if(in_array($file_ext, $allowed)) 
        {
            if($file_error === 0)
            {
                if($file_size <= 5000000) 
                {
                    // create new unique file name to avoid overwrite
                    $new_file_name = uniqid('', true) . '.' . $file_ext;

                    // file directory
                    $file_destination = '../picture/' . $new_file_name;

                    if (move_uploaded_file($file_tmp, $file_destination)) //เพิ่มภาพใหม่เข้าไปใน Directory
                    {

                        $filepath = "../picture/" . $old_file_name; //path ของไฟล์ภาพเก่า
                        unlink($filepath); //ลบไฟล์ภาพเก่าทิ้ง

                        $success = replace_to_database($new_file_name); //ส่งชื่อไฟล์ภาพใหม่ไปให้ฟังก์ชั่นที่ทำหน้าที่บันทึกมันลงฐานข้อมูล
                        $data = NULL;
                        back();

                    }
                    else {echo "Failed to save the image.";}
                } 
                else {echo "File size is too large.";}
            } 
            else {echo "Error uploading file.";}
        } 
        else {echo "ต้องใส่ไฟล์รูปภาพที่มีนามสกุล 'jpg', 'jpeg', 'png', 'gif' หรือ 'webp' เท่านั้น";}
    }
    else
    {
        $success = replace_to_database($old_file_name);
        $data = NULL;
        back();
    }
}
?>

<?php
function replace_to_database($image_name_parameter)
    {
        $id = $_POST['id'];
        $branch = $_POST['branch'];
        $room = $_POST['room'];
        $instrument = $_POST['instrument'];
        $quantity = $_POST['quantity'];
        $caretaker = $_POST['caretaker'];
        $image = $image_name_parameter;
    
        $conn = new mysqli("localhost","root","P@ssw0rd","laboratory_system");// Create connection
        if ($conn->connect_error){die("Connection failed: " . $conn->connect_error);}// Check connection
    
        $sql = "REPLACE INTO engineering_lab (id, branch, room, instrument, quantity, caretaker, image)
        VALUES ('$id', '$branch', '$room', '$instrument', '$quantity', '$caretaker', '$image');";
    
        $replace = mysqli_query($conn,$sql);
    
        if(!$replace)
        {
            echo "<h3 style = 'color:red'>การแก้ไขข้อมูล เกิดข้อผิดพลาด</h3>";
            echo mysqli_error($conn);
            mysqli_close($conn);
        }
        else
        {
            $sql = "SELECT * FROM engineering_lab WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            $success = mysqli_fetch_array($result);
            mysqli_close($conn);
            return $success;
        }
    }
?>

<?php
function back()
{
    header("refresh: 1.5; url=index.php");
}
?>

<fieldset><legend><?php echo isset($success) ? "<h4 style='color:#0000b3;'>ข้อมูลถูกแก้ไขแล้ว</h4>" : "<h4 style='color:black;'>แก้ไขข้อมูล</h4>"; ?></legend>

<form method="POST" enctype="multipart/form-data">

    <input type="hidden" id="id" name="id" value="<?php echo isset($success) ? $success['id'] : $data['id']; ?>">

    <label for='branch'>สาขา:</label>
    <?php
        if (isset($success))
        {
            echo "<select id='branch' name='branch'>";
            echo "<option value='" . $success['branch'] . "'>" . $success['branch'] . "</option>";
            echo "</select><br>";
        }
        else
        {
            echo "<select id='branch' name='branch'>";
            echo "<option value='โยธา'" . ($data['branch'] == 'โยธา' ? " selected" : "") . ">โยธา</option>";
            echo "<option value='ไฟฟ้า'" . ($data['branch'] == 'ไฟฟ้า' ? " selected" : "") . ">ไฟฟ้า</option>";
            echo "<option value='เครื่องกล'" . ($data['branch'] == 'เครื่องกล' ? " selected" : "") . ">เครื่องกล</option>";
            echo "<option value='อุตสาหการ'" . ($data['branch'] == 'อุตสาหการ' ? " selected" : "") . ">อุตสาหการ</option>";
            echo "<option value='คอมพิวเตอร์'" . ($data['branch'] == 'คอมพิวเตอร์' ? " selected" : "") . ">คอมพิวเตอร์</option>";
            echo "</select><br>";
        }
    ?>

    


  <label for="room">ห้อง:</label>
  <input type="text" id="room" name="room" value="<?php echo isset($success) ? $success['room'] : $data['room']; ?>"><br>

  <label for="instrument">ชื่ออุปกรณ์:</label>
  <input type="text" id="instrument" name="instrument" value="<?php echo isset($success) ? $success['instrument'] : $data['instrument']; ?>"><br>

  <label for="quantity">จำนวน:</label>
  <input style="width: 150px;" type="number" id="quantity" name="quantity" value="<?php echo isset($success) ? $success['quantity'] : $data['quantity']; ?>"><br>

  <label for="caretaker">ผู้ดูแล:</label>
  <input type="text" id="caretaker" name="caretaker" value="<?php echo isset($success) ? $success['caretaker'] : $data['caretaker']; ?>"><br>

  <!--รูปก่า-->
  <label for="old_pic">รูปภาพ:</label>
  &nbsp;<img src="<?php echo isset($success) ? '../picture/'.$success["image"] : '../picture/'.$data["image"]; ?>" width="200" style="display: inline-block; vertical-align: top;"><br>
  <input type="hidden" id="old_pic" name="old_pic" value="<?php echo isset($data['image']) ? $data['image'] : ''; ?>" readonly>


  <!--รูปใหม่-->
    <?php
        if (isset($success))
        {
            echo "<br><br>";
        }
        else
        {
            echo '<label for="new_pic">เปลี่ยนรูป:</label>';
            echo '<input type="file" id="new_pic" name="new_pic"><br><br>';
        }
    ?>

    <?php
        if (isset($success))
        {
            echo "";
        }
        else
        {
            echo '<div class="button"><button type="submit" value="Submit" name="submit">ส่งข้อมูล</button>&nbsp;&nbsp;<a class="back" href="index.php">ย้อนกลับ</a></div>';
        }
    ?>
</form>
</fieldset>

</body>
</html>