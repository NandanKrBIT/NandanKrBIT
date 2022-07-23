<?php include_once('header.php');

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}

if(isset($_SESSION['search'])){
    $search = $_SESSION['search'];
}

?>

     <container class="categorycontainer">
    <div class="categoryHeading"> 
        <?php
        if(isset($_GET['id']) and $_GET['id']!=""){
            $query = mysqli_query($conn, "SELECT * FROM category WHERE cat_id=".$_GET['id']);
            while ($row = mysqli_fetch_array($query)){
                $cat_name = $row['cat_name'];
            }
        }else{
            $cat_name = "...";
        }
            
        ?>
            <h2><?php echo $cat_name; ?> Items</h2>
    </div>
    <div class="categoryContent">
         <div class="categoryCommon">
             <?php
             if(isset($_GET['id']) and $_GET['id']!=""){
                    $query = mysqli_query($conn, "SELECT * FROM items WHERE item_category=".$_GET['id']);
             }else if($_GET['id']==""){
                    $query = mysqli_query($conn, "SELECT * FROM items WHERE item_name LIKE '%{$search}%'");
             }
                    while ($row = mysqli_fetch_array($query)){
                      $id = $row['item_id'];
                      $item_img = $row['item_img'];
                      $item_name = $row['item_name'];
                      $item_price = $row['item_price'];
                    ?>
                        <div class="item">
                        <form method="post">
                           <input type="hidden" name="items_id" value="<?php echo $id; ?>">

                           <img src="items/<?php echo $item_img; ?>" alt="<?php echo $item_name; ?>">
                           <h2><?php echo $item_name; ?></h2>
                           <p>&#8377;<?php echo $item_price; ?>/Kg</p>
                           <button type="submit" name="Add_To_Cart" class="cart">Add To Cart</button>

                        </form>
                        </div>
                    <?php }  ?>
         </div>
     </div>
 </container>

<?php include_once('footer.php') ?>

<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    
    if(isset($_POST['Add_To_Cart'])){
        $items_id = $_POST['items_id'];
        $user_id = $_SESSION['user_id'];
        $quantity = "";

        $query = mysqli_query($conn, "SELECT * FROM manage_cart WHERE user_id='$user_id' AND item_id='$items_id'");
        while ($row = mysqli_fetch_array($query)){
          $quantity = $row['quantity'];
        }

        if($quantity){
            $query = mysqli_query($conn, "UPDATE manage_cart SET quantity='$quantity'+1 WHERE user_id='$user_id' AND item_id='$items_id'");
        }else{
            $query = mysqli_query($conn, "INSERT INTO manage_cart(user_id, item_id, quantity) VALUES('$user_id','$items_id', 1)");
        }

        if($query){
            $id = $_GET["id"];
            echo "<script>window.location.href='items.php?id=$id'</script>";
        }
    }
}
?>