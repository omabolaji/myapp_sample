  <!-- SESSION -->
  <?php require_once ("../includes/session.php"); ?>

<!-- DATABASE CONNECTION -->
<?php require_once ("../includes/db_connect.php"); ?>
        <!-- FUNCTION -->
<?php require_once ("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

      <!-- FORM VALIDATION -->
<?php require_once ("../includes/validation_functions.php"); ?>

<?php $layout_context = "Admin"; ?>   
<?php include ("../includes/layout/header.php"); ?>

<!-- Calling data if isset -->
<?php find_select_page_or_subject_if_isset() ?>

   <?php
  if(!$current_subject){
   //subject ID was missing or invalid
    redirect_to("manage_content.php");
  }
   ?>

<?php
if(isset($_POST['submit'])){
    
    //Validation 
    $required_fields = array("menu_name", "position", "visible");
     validate_presences($required_fields);

    $fields_with_max_lengths = array("menu_name" => 30);
    validate_max_lengths($fields_with_max_lengths);

    if(empty($errors)){
        
        //Form processing
    $id = $current_subject["id"];
    $menu_name = $_POST['menu_name'];
    $position = (int) $_POST['position'];
    $visible = (int) $_POST['visible'];

    $safe_menu_name = mysqli_real_escape_string($connection,$menu_name);
    

 $query = "UPDATE subjects SET ";
 $query .= "menu_name = '{$menu_name}', ";
 $query .= "position = {$position}, ";
 $query .= "visible = {$visible} ";
 $query .= "WHERE id = {$id} ";
 $query .= "LIMIT 1";
  $result = mysqli_query($connection,$query);
    
  if($result && mysqli_affected_rows($connection) >= 0){

    $_SESSION["message"] = "Subject updated Successfully!";
      redirect_to("manage_content.php");
     
   }else{
    $message = "Subject update Failed!";
    
   }

}else{

}
}
?>



     <!-- SIDEBAR NAVIGATION START-->
<div class="d-flex">
    <div class="sidebar bg-warning sidebar-light">

 <a class="p-3 text-danger" href="manage_admin.php">&laquo; <b>Main menu</b></a><br><br>

        <ul class="list-unstyled selected">

         <!-- DATABASE QUERY 1-->
<?php $subject_set = find_all_subjects(false); ?>
   
          
    <?php
    // USE RETURNE DATA //OUTPUT DATA FROM EACH ROW
while($subject = mysqli_fetch_assoc($subject_set)){

 ?>
      <?php

   echo "<li";
if($subject["id"] == $select_subject_id){
   echo " class=\"subject\"";
}
   echo ">";

   ?>

  <!-- <li class="subject">     -->
<a href="manage_content.php?subject=<?php echo urlencode($subject["id"]); ?>"><?php echo htmlentities($subject["menu_name"]); ?></a>

        <!-- DATABASE QUERY 2-->
                <?php
     $page_set = find_pages_for_subjects($subject["id"], false);
                ?>
<ul class="pages">

<?php   
while($page = mysqli_fetch_assoc($page_set)){ 
 ?>

       <?php
    echo "<li";
    if($page["id"] == $select_page_id){
    echo " class=\"subject\"";
    }
    echo ">";
         ?>       

<a href="manage_content.php?page=<?php echo urlencode($page["id"]); ?>"><?php echo htmlentities($page["menu_name"]); ?></a> </li>
 <?php
   }
   ?>
<?php mysqli_free_result($page_set); ?>
</ul>
</li>

     <?php
        }
        ?>
<?php mysqli_free_result($subject_set); ?>
        </ul>
        
    </div>  
    <!-- SIDEBAR NAVIGATION END-->


        <!-- BODY -->
    <div class="content">
       <div class="col-xs-8">

     <?php if(!empty($message)){ echo htmlentities($message); }?>
       
      <?php echo form_errors($errors); ?>

         <h2 class="p-3"><b>Edit Subject: </b><?php echo htmlentities($current_subject["menu_name"]); ?></h2>
         <div class="row">
    <form action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
             <div class="input-group">
               <label for="Menu name"><b>Menu name :</b></label>
            <input type="text" name="menu_name" class="form-control" value="<?php echo htmlentities($current_subject["menu_name"]); ?>">
                  </div>
                       <br>

                  <div class="input-group">
                  <label for="Position"><b>Position :</b></label>
            <select name="position" class="form-control">
                    <?php
$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set);
for( $count = 1; $count <= $subject_count; $count++){
  echo "<option value=\"{$count}\"";
     if($current_subject["position"] == $count){
         echo " selected";
     }
  echo ">{$count}</option>";
   }
                    ?>
                    </select>   
                  </div>
                  <br>
                  <div class="input-group">
                  <label for="Visible"><b>Visible :</b></label>
                   <input type="radio" class="form-control" name="visible" value="1" <?php if($current_subject["visible"] == 1){ echo "checked"; } ?> >Yes
                   <input type="radio" class="form-control" name="visible" value="0" <?php if($current_subject["visible"] == 0){ echo "checked"; } ?> >No
                  </div>
                  <br>
                  <input type="submit" name="submit" class="btn btn-primary" value="Update Subject">
                </form>
             </div>
                <br>
    <a class="text-warning" href="manage_content.php">
     <b>Cancel</b></a>
                &nbsp;
                &nbsp;
    <a class="text-danger" href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onClick=" return confirm('Are you sure you want to delete this Subject?')">
     <b>Delete Subject</b></a>

                <!-- $id = $current_subject["id"];
     echo "<a onClick=\"javascript: return confirm('Are you sure you want to delete this Subject?'); \"  class=\"text-danger\" href=\"delete_subject.php?subject=$id\"><b>Delete Subject</b></a>";  -->
               
       </div>
   </div>
<!-- FOOTER  -->
<?php include ("../includes/layout/footer.php"); ?>
