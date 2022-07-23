<?php include_once('header.php') ?>
    <container class="signupcontainer">
    <div class="signupheading">
        <h2>Online Grocery</h2>
        <p><b>New user registration</b></p>
        <hr>
    </div>
    <div class="signupform">
           <form action="" method="post">
               <div class="element">
                   <input type="text" name="firstname" placeholder="Enter the first name">
                   <input type="text" name="lastname" placeholder="Enter the Last name">
               </div>
               <div class="element">
                   <input type="email" name="email" placeholder="Enter the email">
                   <input type="number" name="mobno" id="mobile" placeholder="Enter the mob no.">
               </div>
               <div class="element">
                   <input type="password" name="pass" placeholder="Enter the password">
                   <input type="password" name="repass" placeholder="Re-Enter the password">
               </div>
               <div class="element">
                   <textarea name="address" id="add" placeholder="Enter the Address Details"></textarea>
               </div>
               <div class="btns">
                    <span><input type="submit" name="save" value="SignUP" id="s1"></span>
                    <span><input type="reset" value="Reset" id="r1"></span>
                </div>
           </form>
    </div>
    </container>
<?php include_once('footer.php') ?>

<?php
  if(isset($_POST['save'])){
    $f_name = mysqli_real_escape_string($conn, $_POST['firstname']);
    $l_name = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobno']);
    $pass = md5(mysqli_real_escape_string($conn, $_POST['pass']));
    $repass = md5(mysqli_real_escape_string($conn, $_POST['repass']));
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    if($pass==$repass){
      $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' OR mobile='$mobile'");
      $row = mysqli_num_rows($query);
      if($row > 0){
        $error = 'This email or mobile is not allowed!';
        echo "<script>window.open('signup.php?error=".$error."','_self');</script>";
        exit();
      }else{
        $query = mysqli_query($conn, "INSERT INTO users(f_name,l_name,email,mobile,password,address) VALUES('$f_name','$l_name','$email','$mobile','$pass','$address')");
        if($query){
          $done = 'Successfully saved. Thanks';
          echo "<script>window.open('login.php?done=".$done."','_self');</script>";
          exit();
        }else{
          $error = 'Something Wrong!';
          echo "<script>window.open('signup.php?error=".$error."','_self');</script>";
          exit();
        }
      }
    }else
      $error = 'Password Not Matched!';
      echo "<script>window.open('signup.php?error=".$error."','_self');</script>";
      exit();
    }
?>