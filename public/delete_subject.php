 <!-- SESSION -->
 <?php require_once ("../includes/session.php"); ?>

<!-- DATABASE CONNECTION -->
<?php require_once ("../includes/db_connect.php"); ?>
        <!-- FUNCTION -->
<?php require_once ("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>


 <?php find_select_page_or_subject_if_isset(); ?>

 <?php

  $page_set = find_pages_for_subjects($current_subject["id"]);

  if(mysqli_num_rows($page_set) > 0){

    $_SESSION["message"] = "Can't delete a Subject with pages!";
    redirect_to("manage_content.php?subject={$current_subject["id"]}");
  }

      $current_subject = find_subject_id($_GET["subject"], false);
  if(!$current_subject) {

    redirect_to("manage_content.php");
  }

   $id = $current_subject["id"];
   $query = "DELETE FROM subjects WHERE id = $id ";
   $query .= "LIMIT 1";
   $result = mysqli_query($connection, $query);
   
   if($result && mysqli_affected_rows($connection) == 1){
       $_SESSION["message"] = "Subject Delete successfully!";
      redirect_to("manage_content.php");
   }else{
    $_SESSION["message"] = "Subject Failed to Delete!";
    redirect_to("manage_content.php?subject={$id}");
   }
    


 ?>