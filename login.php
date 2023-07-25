
<?php
//alert is for successfull created account
 $login = false;
 //error is user entered mismatch password
 $showError = false;
//if methos formmethos is post
if($_SERVER['REQUEST_METHOD'] == 'POST'){
 
  //for establishing connection to databse server
  include 'partials\db_connect.php';
  //by default alert is false
 
  $username = $_POST['username'];
  $password = $_POST['password'];
  

  $exists = false;
  //query to check existing from database
  $sql = "Select * from users where username = '$username' AND password = '$password'";
  $result = mysqli_query($conn,$sql);
  //gets number of users accoutn count from database
  $num = mysqli_num_rows($result);
  //check is user have only one number of account
      if($num==1){
        $login = true;
        //after successfully login session is stared 
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username']= $username;

        //now redirectt user using header by giving location of php file
        header("Location: home.php");

      }
      else{
              //if user password is not match
           $showError = "Please Enter Correct Username or Password";
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
            Login Form
         </div>
         <form action="login.php" method="post">
            <div class="field">
               <input type="text" id="username" name="username" required>
               <label for="username">Username</label>
            </div>
            <div class="field">
               <input type="password"  id="password" name="password" required>
               <label for="password">Password</label>
            </div>
            <div class="content">
               <div class="pass-link">
                  <a href="#">Forgot password?</a>
               </div>
            </div>
            <div class="field">
               <input type="submit" value="Login">
            </div>
            <div class="signup-link">
               Not a member? <a href="signup.php">SignUp now</a>
            </div>
         </form>
      </div>
   </body>
</html>