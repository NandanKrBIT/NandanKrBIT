<?php include_once('header.php');

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}

?>

     <container class="categorycontainer">
    <div class="categoryHeading"> 
            <h2>Search Items</h2>
    </div>
    <div class="categoryContent">
         <div class="categoryCommon">
             <?php
             if(isset($_POST['search_btn']) and $_POST['search']!=""){
                 $search = $_POST['search'];
                 $_SESSION['search'] = $_POST['search'];
                    $query = mysqli_query($conn, "SELECT * FROM items WHERE item_name LIKE '%{$search}%'");
                    if(mysqli_num_rows($query)>0){
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
                    <?php } }else{
                        echo '<div class="item">No Record Found</div>';
                    }
                } ?>
         </div>
     </div>
 </container>

<?php include_once('footer.php') ?>

<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    
    if(isset($_POST['Add_To_Cart'])){
        $items_id = $_POST['items_id'];
        $user_id = $_SESSION['user_id'];

        $query = mysqli_query($conn, "INSERT INTO manage_cart(user_id, item_id) VALUES('$user_id','$items_id')");
        if($query){
            $id = $_GET["id"];
            echo "<script>window.location.href='items.php?id=$id'</script>";
        }
    }
}
?>