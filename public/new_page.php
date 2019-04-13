  <!-- SESSION -->
  <?php require_once ("../includes/session.php"); ?>

<!-- DATABASE CONNECTION -->
<?php require_once ("../includes/db_connect.php"); ?>
        <!-- FUNCTION -->
<?php require_once ("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

   <!-- validation form -->
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
if(isset($_POST["submit"])){
    
    //Validation 
    $required_fields = array("menu_name", "position", "visible", "content");
     validate_presences($required_fields);

    $fields_with_max_lengths = array("menu_name" => 30);
    validate_max_lengths($fields_with_max_lengths);

    if(empty($errors)){
        
        //Form processing
    $subject_id = $current_subject['id'];
    $menu_name = $_POST['menu_name'];
    $position = (int) $_POST['position'];
    $visible = (int) $_POST['visible'];
    $content = $_POST['content'];

    $safe_menu_name = mysqli_real_escape_string($connection,$menu_name);
    $safe_content = mysqli_real_escape_string($connection,$content);
    

 $query = "INSERT INTO pages(subject_id, menu_name, position, visible, content) VALUES({$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}') ";
 
  $result = mysqli_query($connection,$query);
    
  if($result){

    $_SESSION["message"] = "Page created Successfully!";
      redirect_to("manage_content.php?subject=" . urlencode($current_subject['id']));
     
   }else{
      $_SESSION["message"] = "Page creation Failed!";
    
   }

}else{

}
}
?>


     <!-- SIDEBAR NAVIGATION START-->
<div class="d-flex">
    <div class="sidebar bg-warning sidebar-light">
        <ul class="list-unstyled selected">

         <!-- DATABASE QUERY 1-->
              <?php
$subject_set = find_all_subjects(false);
             ?>
          
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
<a href="manage_content.php?subject=<?php echo urlencode($subject["id"]); ?>"><?php echo $subject["menu_name"]; ?></a>

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

<a href="manage_content.php?page=<?php echo urlencode($page["id"]); ?>"><?php echo $page["menu_name"]; ?></a> </li>
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
    <div class="content2">
       <div class="col-xs-8">

       <?php $errors = errors(); ?>
      <?php echo form_errors($errors); ?>
         <?php echo message(); ?>

         <h2 class="p-3"><b>Create Page</b></h2>
         <!-- <div class="row"> -->
           <form action="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">

             <div class="input-group">
               <label for="Menu name"><b>Menu name :</b></label>
               <input type="text" name="menu_name" class="form-control" value="">
                  </div>
                       <br>

                  <div class="input-group">
                  <label for="Position"><b>Position :</b></label>
                    <select name="position" class="form-control">
                    <?php
$page_set = find_pages_for_subjects($current_subject["id"]);
$page_count = mysqli_num_rows($page_set);
for( $count = 1; $count <= ($page_count + 1); $count++){
echo "<option value=\"{$count}\">{$count}</option>";
   }
                    ?>
                    
                    </select>   
                  </div>
                  <br>
                  <div class="input-group">
                  <label for="Visible"><b>Visible :</b></label>
                   <input type="radio" class="form-control" name="visible" value="1">Yes
                   <input type="radio" class="form-control" name="visible" value="0">No
                  </div>
                  <br>
                <div class="input-group">
                <label for="content"><b>Content : </b></label>
                <textarea name="content" id="" cols="30" rows="5"></textarea>
                </div>
                  <br>
                  <input type="submit" name="submit" class="btn btn-primary" value="Create Page">
              </form>
             </div>
                <br>
                <a class="text-danger" href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]); ?>"><b>Cancel</b></a>
       </div>
   </div>

<!-- FOOTER  -->
<?php include ("../includes/layout/footer.php"); ?>
