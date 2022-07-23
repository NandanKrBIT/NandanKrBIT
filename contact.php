<?php include_once('header.php') ?>     
  <container class="ContactContainer">
       <div class="contactheading">
            <h2>How can we help?</h2>
            <p><b>Write your query inside this contact Form. Our team will contact you.</b></p>
       </div>
       <div class="contactform">
       <form action="" method="post">
           <div class="commondiv">
                   <label for="name">Name</label><br>
                    <input type="text" id="name" placeholder="Enter your name" name="user">
           </div>
           <div class="commondiv">
                    <label for="email">EmailID</label><br>
                    <input type="email" id="email" placeholder="Enter your email-id" name="email">
           </div>
           <div class="commondiv">
                    <label for="name">MobNO</label><br>
                    <input type="text" id="name" placeholder="Enter your Mob no" maxlength="10" name="mobno">
           </div>
           <div class="commondiv">
                    <label for="msg">Message</label><br>
                    <input type="text" id="msg" placeholder="Enter your message" name="message">
           </div>
           <div class="commondiv">
                    <label for="details">Additional Details</label><br>
                    <textarea  id="details" cols="30" rows="10" name="details"></textarea>
           </div>
           <input type="submit" id="send" value="Send Message" name="send">
        </form>
       </div>
  </container>
<?php include_once('footer.php') ?>
<?php
    if(isset($_POST['send']))
    {
     $name = mysqli_real_escape_string($conn, $_POST['user']);
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $mobno = mysqli_real_escape_string($conn, $_POST['mobno']);
     $message = mysqli_real_escape_string($conn, $_POST['message']);
     $details =mysqli_real_escape_string($conn, $_POST['details']);
     $query = mysqli_query($conn, "INSERT INTO msgs(name,email,mobno,message,details) VALUES('$name','$email','$mobno','$message','$details')");
        if($query){
          $done = 'Successfully saved. Thanks';
          echo "<script>window.open('contact.php?done=".$done."','_self');</script>";
          exit();
        }else{
          $error = 'Something Wrong!';
          echo "<script>window.open('contact.php?error=".$error."','_self');</script>";
          exit();
        }
    }
?>