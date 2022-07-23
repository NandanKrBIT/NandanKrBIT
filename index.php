<?php include_once('header.php') ?>

    <container id="" class="indexcontainer">
        <div class="slider">
        <img src="https://source.unsplash.com/1200x400/?fooditems,fruits,vegetabeles" alt="">
        </div>
        <div class="mainitems">
            <div class="heading">
                  <h2>Grocery Items Category</h2>
            </div>
            <div class="itemslist">
                 <div class="itemscommon">
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM category");
                    while ($row = mysqli_fetch_array($query)){
                    ?>
                        <div class="items">
                            <img src="category/<?php echo $row['cat_img']; ?>" alt="<?php echo $row['cat_name']; ?>">
                            <a href="items.php?id=<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name']; ?></a>
                        </div>
                    <?php } ?>
                 </div> 
            </div>
        </div>
    </container>

<?php include_once('footer.php') ?>