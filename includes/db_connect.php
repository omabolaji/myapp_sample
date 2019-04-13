
<?php
 //CREATING CONNECTION TO DATABASE
 define("DB_SERVER", "localhost");
 define("DB_USER", "root");
 define("DB_PASS", "");
 define("DB_NAME", "widget_corp");

 $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

   //TESTING FOR IF THERE IS ANY ERROR FOR CONNECTION
   if(mysqli_connect_errno()){
       die("DATABASE CONNECTION FAILED! " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")"
    );
   }

?>