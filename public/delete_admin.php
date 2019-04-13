<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connect.php"); ?> 
 <?php require_once ("../includes/functions.php"); ?>
 <?php confirm_logged_in(); ?>


<?php
if(isset($_GET["delete"])){

    $user_id = $_GET["delete"];


$query = "DELETE FROM users WHERE user_id = $user_id ";
$delete_result = mysqli_query($connection, $query);
 if($delete_result && mysqli_affected_rows($connection) == 1){

    $_SESSION["message"] = " You just delete a user! ";
     redirect_to("manage_admins.php");

 }else{
     $_SESSION["message"] = " Failed to delete a user!";
     redirect_to("manage_admins.php");
 }

}
?>