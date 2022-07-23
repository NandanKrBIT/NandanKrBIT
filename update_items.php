<?php include_once('header.php'); 
if(isset($_POST)){
  $item_id=$_GET['id'];
  $query = mysqli_query($conn, "SELECT * FROM (items) WHERE (item_id=$item_id)");
  while ($row = mysqli_fetch_array($query)){
    $item_name=$row['item_name'];
    $item_img_old=$row['item_img'];
    $item_price=$row['item_price'];
    $item_category=$row['item_category'];
  }

    $query = mysqli_query($conn, "SELECT * FROM category WHERE cat_id=$item_category");
    while ($row = mysqli_fetch_array($query)){
      $cat_name=$row['cat_name'];
    }
  }
?>
  
	<container class="itemForm">
        <div class="itemDiv">
        <form action="" method="post" enctype="multipart/form-data">
          <table>
              <tr>
                 <thead>
                   <caption>UPDATE ITEMS</caption>
                  </thead>
                  <td><label for="cat">Choose Category</label></td>
                  <td>
			      <select id="category" name="category" required>
				  <?php
          echo "<option selected value=".$item_category.">".$cat_name."</option>";

					$query = mysqli_query($conn, "SELECT * FROM category WHERE cat_id != $item_category");
					while ($row = mysqli_fetch_array($query)){
						echo "<option value=".$row['cat_id'].">".$row['cat_name']."</option>";
					}
				  ?>	
         			
			      </select>
                  </td>
             </tr>
              <tr>
                  <td>
                     <label for="itm_name">Item Name</label>
                  </td>
                  <td>
                    <input  value=<?php echo $item_name?> type="text" placeholder="Enter The Item Name" name="item_name" id="itm_name">
                  </td>
              </tr>
              <tr>
                  <td>
                    <label for="itm_img">Item Image</label>
                  </td>
                  <td>
                     <span><img width="50" height="50" src="../items/<?php echo $item_img_old;?>" alt="">
                      <input type="file" name="item_img" ></span>
                  </td>
              </tr>
              <tr>
                  <td>
                     <label for="itm_price">Item Price</label>
                  </td>
                  <td>
                  <input  value="<?php echo $item_price ?>" type="number" min="0" placeholder="Enter the Price" name="item_price" id="itm_price">
                  </td>
              </tr>
          </table> 
          <input type="submit" value="UPDATE" name="update" id="additm">
        </form>
     </div>
	</container>
</section>
<?php 
if(isset($_POST['update']))
{
  $item_cat=mysqli_real_escape_string($conn, $_POST['category']);
  $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
  $item_price = mysqli_real_escape_string($conn, $_POST['item_price']);

  $type = $_FILES['item_img']['type'];
  $item_img = $_FILES["item_img"]["tmp_name"];

  if($item_img==""){
    $query = mysqli_query($conn, "UPDATE items SET item_name='$item_name',item_price='$item_price',item_category='$item_cat' where item_id='$item_id'");
  }else{

    function compress_image($source_url, $destination_url, $quality, $date)
       {
          $info = getimagesize($source_url);

          if ($info['mime'] == 'image/jpeg')
          $image = imagecreatefromjpeg($source_url);

          elseif ($info['mime'] == 'image/gif')
          $image = imagecreatefromgif($source_url);

          elseif ($info['mime'] == 'image/png')
          $image = imagecreatefrompng($source_url);

          imagejpeg($image, $destination_url, $quality, $date);
          return $date.'.jpg';
        }
          
        if (($type == "image/jpeg") || ($type == "image/jpg") || ($type == "image/png") || ($type == "image/pjpeg")){
            if ($_FILES["item_img"]["error"] > 0) {
              $error = $_FILES["item_img"]["error"];
              echo "<script>window.open('update_items.php?error=".$error."','_self');</script>";
              exit();
            }

            $query = mysqli_query($conn, "UPDATE items SET item_name='$item_name',item_img='".compress_image($_FILES["item_img"]["tmp_name"], '../items/'.date('dmYHis').'.jpg', 40, date('dmYHis'))."', item_price='$item_price',item_category='$item_cat' where item_id='$item_id'");

          array_map('unlink', glob("../items/$item_img_old"));
        }
      }

  if($query)
  {
    $done = 'Updated Successfully.';
    echo "<script>window.open('dashboard.php?done=".$done."','_self');</script>";
    exit();
  }
  else{
    $error = 'Something went Wrong!';
    echo "<script>window.open('update_items.php?error=".$error."','_self');</script>";
    exit();
  }
}
?>



