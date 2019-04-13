   <!-- SESSION -->
   <?php require_once ("../includes/session.php"); ?>

<!-- DATABASE CONNECTION -->
<?php require_once ("../includes/db_connect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php $layout_context = "Public"; ?>
<?php include ("../includes/layout/header.php"); ?>

<!-- Calling data if isset -->
<?php find_select_page_or_subject_if_isset(true); ?>

     <!-- SIDEBAR NAVIGATION START-->
<div class="d-flex">

    <div class="sidebar bg-warning sidebar-light">
        <ul class="list-unstyled selected">
          <li><a href="login.php">&laquo;<b>Login</b></a></li>
      <br>
         <!-- DATABASE QUERY 1-->
              <?php
$subject_set = find_all_subjects();
             ?>
          
    <?php
    // USE RETURNE DATA //OUTPUT DATA FROM EACH ROW
while($subject = mysqli_fetch_assoc($subject_set)){

 ?>
      <?php

   echo "<li ";
if($subject["id"] == $select_subject_id){ 
   echo " class=\"subject\" ";
  }
   echo "> ";

   ?>

  <!-- <li class="subject">     -->
<a href="index.php?subject=<?php echo urlencode($subject["id"]); ?>"><?php echo htmlentities($subject["menu_name"]); ?></a>

        <!-- DATABASE QUERY 2-->
                <?php
    if($select_subject_id == $subject["id"] || $select_page_id == $subject["id"]){
     $page_set = find_pages_for_subjects($subject["id"]);
                ?>
<ul class="pages">

<?php while($page = mysqli_fetch_assoc($page_set)){
    //    $content = $page["content"];
    ?>
       <?php
    echo "<li ";
    if($page["id"] == $select_page_id){ 
    echo " class=\"subject\" ";
    }
    echo "> ";
         ?>       
<a href="index.php?page=<?php echo urlencode($page["id"]); ?>"><?php echo htmlentities($page["menu_name"]); ?></a> </li>
 <?php } ?>
    </ul>
    <?php mysqli_free_result($page_set); ?>
   <?php } ?>
    </li>
    <?php } ?>
    <?php mysqli_free_result($subject_set); ?>
            </ul>

        </div>  
    <!-- SIDEBAR NAVIGATION END-->


        <!-- BODY -->
        <div class="container">
    <div class="content">
        <!-- PULLING SUBJECT MENU NAME TO THE SCREEN -->
           <br>
    <!-- PULLING PAGE MENU NAME TO THE SCREEN -->
    <?php if($current_page) { ?>

  <h3><b class="text-success"><?php  echo htmlentities($current_page["menu_name"]);
  ?></b></h3>
Content: <b class="text-info"><?php  echo nl2br(htmlentities($current_page["content"]));
  ?></b>
 
<?php } else { ?>

   <p>Welcome to our Awesome Web page!</p>

<?php } ?> 
    </div>
  </div>
</div>

<!-- FOOTER  -->
<?php include ("../includes/layout/footer.php"); ?>
