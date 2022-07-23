<?php include_once('header.php'); 
    $user_id = $_SESSION['user_id'];

    if(isset($_POST))
    {
        
        $id = $_GET['id'];
        $que ="DELETE FROM manage_cart WHERE mc_id='$id' AND user_id='$user_id'";
        $run=mysqli_query($conn,$que);
        if($run){
            echo "<script>window.open('manage_cart.php?done=Item removed successfully.','_self')</script>";
        }
        else{
            echo "<script>window.open('manage_cart.php?error= Something went wrong .','_self')</script>";
        }
    }

?>