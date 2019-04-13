<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php require_once ("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php $layout_context = "Admin"; ?>
<?php include ("../includes/layout/header.php"); ?>
 
 
 <!-- SIDEBAR -->
 <div class="d-flex">
        <div class="sidebar bg-dark sidebar-info ">
            <ul class="list-unstyled dropDown">
              <a href="admin.php">Back to admin</a>
            </ul>
        </div>
            <!-- BODY -->
    <div class="container">
      <div class="content1">
        <h2 class="text-success">Manage Admins</h2>
        <p>Welcome to the manage admin center, <b><?php echo htmlentities($_SESSION["username"]); ?></b></p>


       <?php echo message(); ?>

        <?php
    if(isset($_GET["user_id"])){
        $user_id = $_GET["user_id"];
    }    
            ?>

   <div class="col-lg-12">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <!-- <th>password</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

$query = "SELECT * FROM users ";
$result = mysqli_query($connection, $query);

 while($row = mysqli_fetch_assoc($result)){
     $user_id = $row["user_id"];
     $username = $row["username"];
    //  $hashed_password = $row["password"];
 
               echo "<tr>";
                echo "<td>{$username}</td>";
                // echo "<td>{$hashed_password}</td>";
                   echo "<td>"; 
          echo "<a href=\"edit_admin.php?edit_user={$user_id}\"><b>Edit</b></a>";
                           echo "&nbsp";
                           echo "&nbsp";
           echo "<a onClick=\"javascript: return confirm('Are you sure you want to delete this user!');\" href=\"delete_admin.php?delete={$user_id}\"><b>Delete</b></a>";
                     echo "</td>";
               echo "</tr>";
 }
                ?>
            </tbody>
        </table>
        <a href="new_admin.php"><b>+ Add new admin</b></a>
    </div>
      </div>
    </div>
   
<?php include ("../includes/layout/footer.php"); ?>
