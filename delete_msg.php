
<?php 
   include_once("connect_db.php");
   if(isset($_GET['id']))
   {
      $id=$_GET['id'];
      $query=mysqli_query($conn,"DELETE FROM msgs WHERE id=$id");
      if($query)
      {
          $done = 'Deleted Successfully.';
          echo "<script>window.open('dashboard.php?done=".$done."','_self');</script>";
          exit(); 
      }
      else{
        $error = 'Something went Wrong!';
        echo "<script>window.open('dashboard.php?error=".$error."','_self');</script>";
        exit();
      }
   }
   
?>