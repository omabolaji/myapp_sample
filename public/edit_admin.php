<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php require_once ("../includes/validation_functions.php"); ?>
<?php $layout_context = "Admin"; ?>
 <?php include ("../includes/layout/header.php"); ?>



<?php

if(isset($_GET["edit_user"])){
    $the_user_id = $_GET["edit_user"];


  $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
  $update_query = mysqli_query($connection, $query);

  while($row = mysqli_fetch_assoc($update_query)){
      $user_id = $row["user_id"]; 
      $username = $row["username"];
      $password = $row["password"];
  }
}

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

   $query = "UPDATE users SET ";
   $query .= "username = '{$username}', ";
   $query .= "password = '{$hashed_password}' ";
   $query .= " WHERE user_id = '{$the_user_id}' ";
   $query .= "LIMIT 1 ";

   $result_update = mysqli_query($connection, $query);

   if($result_update && mysqli_affected_rows($connection) == 1){

     $_SESSION["message"] = " You just updated a user successfully!";
     redirect_to("./manage_admins.php"); 
  }else{
      $message = "Failed to update user!";
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

        <?php if(!empty($message)){ echo htmlentities($message); }?>
       
       <?php echo form_errors($errors); ?>

        <div class="col-md-4">
  <form action="edit_admin.php?edit_user=<?php echo $user_id; ?>" method="post">

  <div class="input-group">
      <label for="username"><b>Username : </b></label>
      <input type="text" name="username" class="form-control" placeholder="Enter username.." value="<?php echo $username; ?>">
  </div>
<br>
  <div class="input-group">
      <label for="password"><b>Password : </b></label>
      <input type="password" name="password" class="form-control" placeholder="Enter password.." value="<?php echo $password; ?>">
  </div>
  <br>
   <input type="submit" name="submit" value="Edit User" class="btn btn-primary">
   &nbsp;
   &nbsp;
   <a class="text-warning" href="manage_admins.php">Cancel</a>
  </form>
  
    </div>
      </div>
    </div>
   
<?php include ("../includes/layout/footer.php"); ?>
