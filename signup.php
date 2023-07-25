
<?php
//alert is for successfull created account
 $showAlert = false;
 //error is user entered mismatch password
 $showError = false;
//if methos formmethos is post
if($_SERVER['REQUEST_METHOD'] == 'POST'){
 
  //for establishing connection to databse server
  include 'partials\db_connect.php';
  //by default alert is false
 
  $username = $_POST['username'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];

  $exists = false;
  //query to check existing from database
  $existSql = "SELECT * FROM `users` where `username` = '$username'";
  //this below function of mysqli extension takes two parameters, connection variable and another
  $result = mysqli_query($conn,$existSql);
  //This numExistRows store number of username count in all rows returned by above sql qrery
  $numExistRows = mysqli_num_rows($result);

  //check if user exists more than one times
        if($numExistRows>0){
          // $exists=true; //user exists more than once
          $showError = "UserName Is Already Exists, Please Choose Another";
        }
       else{
          //  $exists=false;
          //check wether user already loginn or not, also check password and currrent password
          if(($password==$cpassword)){
            //sql query to insert data into database
            $sql = "INSERT INTO `users` (`username`, `password`, `Date`) VALUES ('$username', '$password', current_timestamp())";
            $result = mysqli_query($conn,$sql);
                if($result){
                  $showAlert = true;        
                }
                header("Location: login.php");
          }
          else{
            //if user password is not match
            $showError = "Please Enter Same Password To Create Account";
          }
}
}

?>


<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Sign Up Page</title>
        <!-- bootstrap css for alert purposr -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="css\style.css">
   </head>
   <body>


  
  <!-- if user created accountat that time showing this alert -->
  <?php
    if($showAlert){
     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your account is now created Please Login.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>';
    }

    if($showError){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       <strong>Error!</strong> '.$showError.'
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
       </div>';
     }
   ?>


      <div class="wrapper">
         <div class="title">
            SignUp
         </div>
         <form action="signup.php" method="post">
            <div class="field">
               <input type="text" id="username" name="username" required>
               <label for="username">Username</label>
            </div>
            <div class="field">
               <input type="password"  id="password" name="password" required>
               <label for="password">Password</label>
            </div>
            <div class="field">
               <input type="password"  id="cpassword" name="cpassword" required>
               <label for="password">Conform Password</label>
            </div>
            <div class="content">
               <div class="checkbox">
                  <input type="checkbox" id="remember-me">
                  <label for="remember-me">Remember me</label>
               </div>
            </div>
            <div class="field">
               <input type="submit" value="Sign Up">
            </div>
            <div class="signup-link">
               Already a member? <a href="login.php">Login Now</a>
            </div>
         </form>
      </div>
   </body>
</html>