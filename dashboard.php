<?php include_once('header.php'); ?>
<section class="contact">
	<container class="categoryForm">
	  <div class="categoryDiv">
          <form action="" method="post" enctype="multipart/form-data">
          <table>
               <thead>
                   <caption>ADD CATEGORY</caption>
               </thead>
              <tr>
                <td><label for="catname"> Category Name</label></td>
                <td><input type="text" name="cat_name" placeholder="Enter the category name" id="catname"></td>   
              </tr>
              <tr>
                  <td><label for="">Choose Category</label></td>
                  <td><input type="file" name="cat_img"></td>
              </tr>
          </table>
             <input type="submit" value="Add Category" name="add_category" id="addcat">
	     </form>
	    </div>
	  </container>   
	<container class="itemForm">
        <div class="itemDiv">
        <form action="" method="post" enctype="multipart/form-data">
          <table>
              <tr>
                 <thead>
                   <caption>ADD ITEMS</caption>
                  </thead>
                  <td><label for="cat">Choose Category</label></td>
                  <td>
                  <select id="category" name="category" required>
				  <?php
					$query = mysqli_query($conn, "SELECT * FROM category ");
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
                    <input type="text" placeholder="Enter The Item Name" name="item_name" id="itm_name">
                  </td>
              </tr>
              <tr>
                  <td>
                    <label for="itm_img">Item Image</label>
                  </td>
                  <td>
                     <input type="file" name="item_img">
                  </td>
              </tr>
              <tr>
                  <td>
                     <label for="itm_price">Item Price</label>
                  </td>
                  <td>
                  <input type="number" min="0" placeholder="Enter the Price" name="item_price" id="itm_price">
                  </td>
              </tr>
          </table> 
          <input type="submit" value="Add Items" name="add_item" id="additm">
        </form>
     </div>
	</container>
</section>
<section class="usermsg">
         <div class="contain">
           <h2>User's Responses</h2>
         <table class="users">
             <tr>
               <th>S.No</th>
               <th>Name</th>
               <th>Email</th>
               <th>Mobile</th>
               <th>Title</th>
               <th>Message</th>
               <th>Delete</th>
             </tr>
             <?php
                    $query = mysqli_query($conn, "SELECT * FROM  msgs");
                    $i=1;
                    while ($row = mysqli_fetch_array($query)){
              ?>
             <tr>
     
                <td><?php echo $i; ?></td>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['mobno'];?></td>
                <td><?php echo $row['message'];?></td>
                <td><?php echo $row['details'];?></td>
                <td><a id="delete"href="delete_msg.php?id=<?php echo $row['id']; ?>">&times;</a></td>
             </tr>
            <?php $i++; } ?>
         </table>
         </div>
</section>



<section class="usermsg">
         <div class="contain">
           <h2>Item's List</h2>
         <table class="users">
             <tr>
               <th>S.No</th>
               <th>Item Name</th>
               <th>Item Price</th>
               <th>Category</th>
               <th>Item Image</th>
               <th>Update</th>
               <th>Delete</th>
             </tr>
             <?php
                    $query = mysqli_query($conn, "SELECT * FROM items,category WHERE items.item_category=category.cat_id");
                    $i=1;
                    while ($row = mysqli_fetch_array($query)){
              ?>
             <tr>
     
                <td><?php echo $i; ?></td>
                <td><?php echo $row['item_name'];?></td>
                <td>&#8377; <?php echo $row['item_price'];?> / Kg</td>
                <td><?php echo $row['cat_name'];?></td>
                <td><img width="100" height="100" src="../items/<?php echo $row['item_img'];?>" alt=""></td>
                <td><a id="update"href="update_items.php?id=<?php echo $row['item_id'];?>">Update</a></td>
                <td><a id="delete"href="delete_items.php?id=<?php echo $row['item_id']; ?>">&times;</a></td>
             </tr>
            <?php $i++; } ?>
         </table>
         </div>
</section>

<?php include_once('footer.php'); ?>

<?php 

if(isset($_POST['add_category'])){
	$cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
    $type = $_FILES['cat_img']['type'];

    $error = ""; $done = "";

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
            if ($_FILES["cat_img"]["error"] > 0) {
              $error = $_FILES["cat_img"]["error"];
              echo "<script>window.open('dashboard.php?error=".$error."','_self');</script>";
              exit();
            }

            $run = mysqli_query($conn, "INSERT INTO category(cat_name, cat_img) values('$cat_name', '".compress_image($_FILES["cat_img"]["tmp_name"], '../category/'.date('dmYHis').'.jpg', 40, date('dmYHis'))."')");

            if($run){
            	$done = 'Saved successfully.';
                echo "<script>window.open('dashboard.php?done=".$done."','_self');</script>";
                exit();
            }else {
                $error = "Problem on uploading image!";
                echo "<script>window.open('dashboard.php?error=".$error."','_self');</script>";
                exit();
            }
        }else{
          $error = "Image type is not valid!";
          echo "<script>window.open('dashboard.php?error=".$error."','_self');</script>";
          exit();
        }
    }


if(isset($_POST['add_item'])){
	$category = mysqli_real_escape_string($conn, $_POST['category']);
	$item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
	$item_price = mysqli_real_escape_string($conn, $_POST['item_price']);
    $type = $_FILES['item_img']['type'];

    $error = ""; $done = "";

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
              echo "<script>window.open('dashboard.php?error=".$error."','_self');</script>";
              exit();
            }

            $run = mysqli_query($conn, "INSERT INTO items(item_name, item_img, item_price, item_category) values('$item_name', '".compress_image($_FILES["item_img"]["tmp_name"], '../items/'.date('dmYHis').'.jpg', 40, date('dmYHis'))."','$item_price', '$category')");

            if($run){
            	$done = 'Saved successfully.';
                echo "<script>window.open('dashboard.php?done=".$done."','_self');</script>";
                exit();
            }else {
                $error = "Problem on uploading image!";
                echo "<script>window.open('dashboard.php?error=".$error."','_self');</script>";
                exit();
            }
        }else{
          $error = "Image type is not valid!";
          echo "<script>window.open('dashboard.php?error=".$error."','_self');</script>";
          exit();
        }
    }
?>
