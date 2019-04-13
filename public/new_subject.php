  <!-- SESSION -->
<?php require_once ("../includes/session.php"); ?>

    <!-- DATABASE CONNECTION -->
    <?php require_once ("../includes/db_connect.php"); ?>
            <!-- FUNCTION -->
<?php require_once ("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

       
<?php $layout_context = "Admin"; ?>
 <?php include ("../includes/layout/header.php"); ?>

   <!-- Calling data if isset -->
 <?php find_select_page_or_subject_if_isset() ?>
 
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
        <div class="content p-4 main1">
           <div class="col-xs-8">

           <?php $errors = errors(); ?>
          <?php echo form_errors($errors); ?>
             <?php echo message(); ?>
   
             <h2 class="p-3"><b>Create Subject</b></h2>
             <div class="row">
               <form action="create_subject.php" method="post">
                 <div class="input-group">
                   <label for="Menu name"><b>Menu name :</b></label>
                   <input type="text" name="menu_name" class="form-control" value="">
                      </div>
                           <br>

                      <div class="input-group">
                      <label for="Position"><b>Position :</b></label>
                        <select name="position" class="form-control">
                        <?php
  $subject_set = find_all_subjects();
  $subject_count = mysqli_num_rows($subject_set);
  for( $count = 1; $count <= ($subject_count + 1); $count++){
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
                      <input type="submit" name="submit" class="btn btn-primary" value="Create Subject">
                    </form>
                 </div>
                    <br>
                    <a class="text-danger" href="manage_content.php"><b>Cancel</b></a>
           </div>
       </div>
    <!-- FOOTER  -->
<?php include ("../includes/layout/footer.php"); ?>
