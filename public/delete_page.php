 <!-- SESSION -->
 <?php require_once ("../includes/session.php"); ?>

<!-- DATABASE CONNECTION -->
<?php require_once ("../includes/db_connect.php"); ?>
        <!-- FUNCTION -->
<?php require_once ("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>


 <?php find_select_page_or_subject_if_isset(); ?>

 <?php
 $current_page = find_page_id($_GET["page"], false);

 if(!$current_page){
    redirect_to("manage_content.php");
 }

   $id = $current_page["id"];
   $query = "DELETE FROM pages WHERE id = $id ";
   $query .= "LIMIT 1 ";
   $result = mysqli_query($connection, $query);
   
   if($result && mysqli_affected_rows($connection) == 1){
       $_SESSION["message"] = "Page Delete successfully!";
      redirect_to("manage_content.php");
   }else{
    $_SESSION["message"] = "Page Failed to Delete!";
    redirect_to("manage_content.php?page={$id}");
   }
    


 ?>