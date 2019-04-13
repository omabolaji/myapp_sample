<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php require_once ("../includes/validation_functions.php"); ?>
<?php $layout_context = "Admin"; ?>
 <?php include ("../includes/layout/header.php"); ?>



<?php

 if(isset($_POST["submit"])){


    //Validation 
    $required_fields = array("username", "password");
     validate_presences($required_fields);

    $fields_with_max_lengths = array("username" => 30);
    $fields_with_max_lengths = array("password" => 30);
    validate_max_lengths($fields_with_max_lengths);

  if(empty($errors)){

     $username = $_POST["username"];
     $hashed_password = $_POST["password"];

      $username = mysqli_real_escape_string($connection, $username);
       $hashed_password = password_encrypt($hashed_password);

   $query = "INSERT INTO users(username, password) VALUES ('{$username}', '{$hashed_password}') ";
   $result = mysqli_query($connection, $query);

   if($result && mysqli_affected_rows($connection) >= 0){

     $_SESSION["message"] = " User has been created successfully!";
     redirect_to("manage_admins.php"); 
  }else{
      $message = "Failed to create user!";
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
        <h2 class="text-success">Create New User</h2>
        <p>Welcome to our admin center</p>

        <div class="col-md-4">

        <?php if(!empty($message)){ echo htmlentities($message); }?>
       
      <?php echo form_errors($errors); ?>

  <form action="new_admin.php" method="post">

  <div class="input-group">
      <label for="username"><b>Username : </b></label>
      <input type="text" name="username" class="form-control" placeholder="Enter username..">
  </div>
<br>
  <div class="input-group">
      <label for="password"><b>Password : </b></label>
      <input type="password" name="password" class="form-control" placeholder="Enter password..">
  </div>
  <br>
   <input type="submit" name="submit" value="Create User" class="btn btn-primary">
   &nbsp;
   &nbsp;
   <a class="text-warning" href="manage_admins.php"><b>Cancel</b></a>
</form>
</div>
      </div>
    </div>
   
<?php include ("../includes/layout/footer.php"); ?>
