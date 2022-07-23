<?php 
    include("./connect_db.php");
    if(isset($_POST))
    {
        
        $id = $_GET['id'];

        $que ="SELECT * FROM items WHERE item_id='$id'";
        $run =mysqli_query($conn, $que);
        
        while($row=mysqli_fetch_array($run))
        {
            $file = $row['item_img'];
        }

        $query = "DELETE FROM items WHERE item_id='$id'";

        if(mysqli_query($conn, $query)){

            //delete specific image file
            if($file !=""){
    		    array_map('unlink', glob("../items/$file"));
            }

            echo "<script>window.open('dashboard.php?done=File deleted successfully.','_self')</script>";
        }
    	else{
    			
    		echo "<script>window.open('dashboard.php?error= File not Deleted.','_self');</script>";
    	}
    }

?>