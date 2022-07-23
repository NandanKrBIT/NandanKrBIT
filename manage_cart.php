<?php include_once('header.php'); 
$user_id = $_SESSION['user_id'];
?>

<section class="usermsg">
         <div class="contain">
           <h2>MY CART</h2>
         <table class="users">
             <tr>
               <th>S.No</th>
               <th>Item Name</th>
               <th>Quantity</th>
               <th>Item Price</th>
               <th>Price</th>
               <th>Item Image</th>
               <th>Remove Item</th>
             </tr>
             <?php
                    $query = mysqli_query($conn, "SELECT DISTINCT(item_name), item_img, item_price, mc_id, quantity FROM items,manage_cart WHERE manage_cart.user_id=$user_id AND items.item_id=manage_cart.item_id");
                    $i = 1;
                    $tq = 0;
                    $tp = 0;
                    while($row = mysqli_fetch_array($query)){
                      $tq = $tq + $row['quantity'];
                      $tp = $tp + $row['item_price'] * $row['quantity'];
              ?>
              <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $row['item_name'];?></td>
                  <td><?php echo $row['quantity'];?></td>
                  <td><?php echo $row['item_price'];?>/kg </td>
                  <td><b>&#8377; <?php echo $row['quantity'] * $row['item_price']; ?></b>/-</td>
                  <td><img width="70" height="70" src="items/<?php echo $row['item_img'];?>" alt=""></td>
                  <td><a id="remove" style="border: 2px solid black;color: black;text-decoration: none; padding:10px;font-weight: bold;background: red;border-radius: 20px;"href="delete_cart_items.php?id=<?php echo $row['mc_id']; ?>">Remove</a></td>
              </tr>
              <?php $i++; } ?>
              <tr>
                <td></td>
                <td></td>
                <td>Total : <b style="color:red;"><?php echo $tq; ?></b></td>
                <td></td>
                <td>Total Price : <b style="color:red;">&#8377; <?php echo $tp; ?>/-</b></td>
                <td></td>
                <td></td>
              </tr>
           </table>
         </div>
</section>

<?php include_once('footer.php'); ?>
