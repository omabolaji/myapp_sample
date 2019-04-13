   <!-- SESSION -->
<?php require_once ("../includes/session.php"); ?>

    <!-- DATABASE CONNECTION -->
<?php require_once ("../includes/db_connect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
 <?php confirm_logged_in(); ?>
<?php $layout_context = "Admin"; ?>
 <?php include ("../includes/layout/header.php"); ?>

   <!-- Calling data if isset -->
 <?php find_select_page_or_subject_if_isset() ?>
 
         <!-- SIDEBAR NAVIGATION START-->
 <div class="d-flex">

        <div class="sidebar bg-warning sidebar-light">
 <a class="p-3 text-danger" href="admin.php">&laquo; <b>Main menu</b></a><br>
 <p class="pl-4"><b> <?php echo htmlentities($_SESSION["username"]); ?></b></p>

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
          <ul>
              <li><a href="new_subject.php">+ Add Subject</a></li>
          </ul>  
        </div>  
        <!-- SIDEBAR NAVIGATION END-->

   
            <!-- BODY -->
            <div class="container">
        <div class="content">
       
            <!-- PULLING SUBJECT MENU NAME TO THE SCREEN -->
            
              <?php echo message(); ?>
            <?php if($current_subject){ ?>
                
            <h2 class="text-info">Manage Subject</h2>

    Menu name: <b class="text-primary"><?php echo htmlentities($current_subject["menu_name"]);?></b>
        <br>
    Position: <b class="text-primary"><?php echo $current_subject["position"]; ?></b>
       <br>
    Visible: <b class="text-primary"><?php echo $current_subject["visible"] == 1 ? 'Yes' : 'No'; ?></b>
          <br><br>
    <a  class="text-danger" href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Edit Subject</a>

          <br>    
          <hr>

          <div>
          <h2 class="text-secondary">Pages in this Subject</h2>
          <ul>
    <?php
 $subject_pages = find_pages_for_subjects($current_subject['id'],false);

   while($page = mysqli_fetch_assoc($subject_pages)){
      echo "<li>";
    $safe_page_id = urlencode($page["id"]);
    echo "<a href='manage_content.php?page={$safe_page_id}'>";
    echo htmlentities($page["menu_name"]);
      echo"</a>";
      echo "</li>";
   }
    ?>
</ul>
<br>
<a href="new_page.php?subject=<?php echo urlencode($current_subject['id']); ?>">+ Add new page to this Subject</a>
</div>
        <!-- PULLING PAGE MENU NAME TO THE SCREEN -->
        <?php } elseif($current_page) { ?>

  <h2 class="text-info">Manage Page</h2>

  Menu name: <b class="text-info"><?php  echo htmlentities($current_page["menu_name"]);
      ?></b>
      <br>
  Position: <b class="text-info"><?php echo $current_page["position"]; ?></b>
    <br>
  Visible: <b class="text-info"><?php echo $current_page["visible"] == 1 ? 'Yes' : 'No'; ?></b>
        <br>
  Content:
  <div class="border p-3 m-1">
  <b class="text-info"><?php echo htmlentities($current_page["content"]); ?></b>
  </div>

    <br>
    <a  class="text-danger" href="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>">Edit Page</a>

    <br>

    <?php } else { ?>

        Please select a Subject or a Page!

   <?php } ?> 
        </div>
      </div>
    </div>

    <!-- FOOTER  -->
<?php include ("../includes/layout/footer.php"); ?>
