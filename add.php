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
        $data = []; // Initialize $data as an empty array
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
        $file = $_FILES['file'];

        // file properties
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

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
                    $file_destination = './picture/' . $new_file_name;

                    // move file to directory
                    if (move_uploaded_file($file_tmp, $file_destination))
                    {
                        $branch = $_POST['branch'];
                        $room = $_POST['room'];
                        $instrument = $_POST['instrument'];
                        $quantity = $_POST['quantity'];
                        $caretaker = $_POST['caretaker'];
                    
                        $conn = new mysqli("localhost","root","P@ssw0rd","laboratory_system");// Create connection
                        if ($conn->connect_error){die("Connection failed: " . $conn->connect_error);}// Check connection
                    
                        $sql = "INSERT INTO engineering_lab (branch, room, instrument, quantity, caretaker, image)
                        VALUES ('$branch', '$room', '$instrument', '$quantity', '$caretaker', '$new_file_name');";
                    
                        $insert = mysqli_query($conn,$sql);
                    
                        if(!$insert)
                        {
                            echo "<h3 style = 'color:red'>การเพิ่มข้อมูล เกิดข้อผิดพลาด</h3>";
                            echo mysqli_error($conn);
                            mysqli_close($conn);
                        }
                        else
                        {
                            $show_id = mysqli_insert_id($conn); 

                            $sql = "SELECT * FROM engineering_lab WHERE id = $show_id";
                            $result = mysqli_query($conn, $sql);
                            $data = mysqli_fetch_array($result);
                            mysqli_close($conn);

                            back();
                        }

                    } else {echo "Failed to save the image.";}
                } else {echo "File size is too large.";}
            } else {echo "Error uploading file.";}
        } else {echo "ต้องใส่ไฟล์รูปภาพที่มีนามสกุล 'jpg', 'jpeg', 'png', 'gif' หรือ 'webp' เท่านั้น";}
    }
?>


<?php
function back()
{
    header("refresh: 1.5; url=index.php");
}
?>

<fieldset><legend><?php echo isset($data) ? "<h4 style='color:#00802b;'>เพิ่มข้อมูลสำเร็จ</h4>" : "<h4 style='color:black;'>เพิ่มข้อมูล</h4>"; ?></legend>
<form method="POST" enctype="multipart/form-data">

    <input type="hidden" id="id" name="id" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>">

    <label for="branch">สาขา:</label>
<select id="branch" name="branch">
    <option value='โยธา' <?php echo ($data['branch'] ?? '' == 'โยธา' ? "selected" : ""); ?>>โยธา</option>
    <option value='ไฟฟ้า' <?php echo ($data['branch'] ?? '' == 'ไฟฟ้า' ? "selected" : ""); ?>>ไฟฟ้า</option>
    <option value='เครื่องกล' <?php echo ($data['branch'] ?? '' == 'เครื่องกล' ? "selected" : ""); ?>>เครื่องกล</option>
    <option value='อุตสาหการ' <?php echo ($data['branch'] ?? '' == 'อุตสาหการ' ? "selected" : ""); ?>>อุตสาหการ</option>
    <option value='คอมพิวเตอร์' <?php echo ($data['branch'] ?? '' == 'คอมพิวเตอร์' ? "selected" : ""); ?>>คอมพิวเตอร์</option>
</select><br>


  <label for="room">ห้อง:</label>
  <input type="text" id="room" name="room" value="<?php echo isset($data['room']) ? $data['room'] : ''; ?>"><br>

  <label for="instrument">ชื่ออุปกรณ์:</label>
  <input type="text" id="instrument" name="instrument" value="<?php echo isset($data['instrument']) ? $data['instrument'] : ''; ?>"><br>

  <label for="quantity">จำนวน:</label>
  <input style="width: 150px;" type="number" id="quantity" name="quantity" value="<?php echo isset($data['quantity']) ? $data['quantity'] : ''; ?>"><br>

  <label for="caretaker">ผู้ดูแล:</label>
  <input type="text" id="caretaker" name="caretaker" value="<?php echo isset($data['caretaker']) ? $data['caretaker'] : ''; ?>"><br>

  <label for="file">รูปภาพ:</label>
  <?php
        if (isset($data['image']))
        {
            echo '&nbsp;<img src="../picture/'.$data['image'].'" width="200" style="display: inline-block; vertical-align: top;"><br>';
        }
        else
        {
            echo '<input type="file" id="file" name="file"><br><br>';
        }
    ?>

    <?php
        if (isset($data['image']))
        {
            echo "<br><br>";
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