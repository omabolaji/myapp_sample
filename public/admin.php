<?php require_once ("../includes/session.php"); ?> 
 <?php require_once ("../includes/functions.php"); ?>
  <?php confirm_logged_in(); ?>
<?php $layout_context = "Admin"; ?>
<?php include ("../includes/layout/header.php"); ?>
 

          <!-- SIDEBAR -->
    <div class="d-flex">
        <div class="sidebar bg-dark sidebar-dark ">   
    </div>

            <!-- BODY -->
    <div class="container">
        <div class="content">
            <h2 class="text-danger">Admin Menu</h2>
            <p class="text-primary">Welcome to the admin area,<h4><?php echo htmlentities($_SESSION["username"]); ?></h4></p>
         
            <ul class="">
                <li><a href="manage_content.php"><b>Manage Website Content</b></a></li>
                <li><a href="manage_admins.php"><b>Manage Admin Users</b></a></li>
                <li><a href="logout.php"><b>Logout</b></a></li>
            </ul>
        </div>
    </div>
  
<?php include ("../includes/layout/footer.php"); ?>
