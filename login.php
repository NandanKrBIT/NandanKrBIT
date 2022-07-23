<?php include_once('header.php'); ?>
   <container class="logincontainer">
      <div class="loginheading">
        <h2>Online Grocery</h2>
        <p>Login via username</p>
        <hr> 
      </div>
      <div class="loginform">
      <form action="" method="post">
        <label for="username"><b>Username</b></label><br>

        <input type="text" placeholder="Enter your username" id="username" name="username"><br>

        <label for="password"><b>Password</b></label><br>

        <input type="password" placeholder="Enter your password"id="password" name ="pass"><br>

        <input type="submit" value="Login" id="login" name="login">
      </form>
      </div>
      <hr>
      <div class="loginfooter"> 
        <span class="psw">Forgot <a href="#">password?</a></span>
        <input type="button" value="Cancel" id="cancelbtn">
      </div>
   </container>
<?php include_once('footer.php') ?>

<?php
  if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = md5(mysqli_real_escape_string($conn, $_POST['pass']));

    
      $query = mysqli_query($conn, "SELECT * FROM users WHERE (email='$username' OR mobile='$username') AND password='$pass'");
      while ($record = mysqli_fetch_array($query)){
        $user_id = $record['user_id'];
      }

      $row = mysqli_num_rows($query);

      if($row == 1){
        $_SESSION['user_id'] = $user_id;
        $done='You have logged in succesfully';
        echo "<script>window.open('index.php?done=".$done."','_self');</script>";
        exit();
      }else{
        $error = 'You have not valid user!';
        echo "<script>window.open('login.php?error=".$error."','_self');</script>";
        exit();
      }
    }
?>