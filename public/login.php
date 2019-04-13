<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php require_once ("../includes/validation_functions.php"); ?>
<?php $layout_context = "Admin"; ?>
 <?php include ("../includes/layout/header.php"); ?>



<?php
$username = "";

 if(isset($_POST["submit"])){


    //Validation 
    $required_fields = array("username", "password");
     validate_presences($required_fields);

  if(empty($errors)){

    $username = $_POST["username"];
    $password = $_POST["password"];
         
      $username = mysqli_real_escape_string($connection, $username);
      $password = mysqli_real_escape_string($connection, $password);

     $found_admin = attempt_login($username, $password);
     if($found_admin){

     $_SESSION["user_id"] = $found_admin["user_id"];
     $_SESSION["username"] = $found_admin["username"];
      redirect_to("admin.php"); 
  }else{
      $_SESSION["message"] = "Username/Password does not matched!";
  }
  }else{
  }
}
  

 

?> 
 
 <!-- SIDEBAR -->
 <div class="d-flex">
        <div class="sidebar bg-dark sidebar-info ">
            
        </div>
            <!-- BODY -->
    <div class="container">
      <div class="new_admin">
        <h2 class="text-success">Users Login Portal</h2>
        <p>Welcome.........</p>

        <div class="col-md-4">

        <?php if(!empty($message)){ echo htmlentities($message); }?>
       
      <?php echo form_errors($errors); ?>

  <form action="login.php" method="post">

  <div class="input-group">
      <label for="username"><b>Username : </b></label>
      <input type="text" name="username" class="form-control" placeholder="Enter username.." value="<?php echo $username; ?>">
  </div>
<br>
  <div class="input-group">
      <label for="password"><b>Password : </b></label>
      <input type="password" name="password" class="form-control" placeholder="Enter password..">
  </div>
  <br>
   <input type="submit" name="submit" value="Login" class="btn btn-primary">
   &nbsp;
   &nbsp;
   <a class="text-warning" href="./index.php"><b>Back to Home page</b></a>
</form>
</div>
      </div>
    </div>
   
<?php include ("../includes/layout/footer.php"); ?>
