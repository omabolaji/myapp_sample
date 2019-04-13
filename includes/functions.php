 
 
 <?php    

 function redirect_to($new_location){

   header("Location: " . $new_location);
   exit;
 }
 
 function confirm_query($result_set){ 

   global $connection;  
 
    if(!$result_set){
       die("DATABASE FAILED! " . mysqli_error($connection));
    }
 }
 
 function find_all_subjects($public=true){
      
   global $connection;

   $query = "SELECT * FROM subjects ";
   if($public){
      $query .= "WHERE visible = 1 ";
   }
   $query .= "ORDER BY position ASC ";
   $subject_set = mysqli_query($connection, $query);

   confirm_query($subject_set);
     return $subject_set;
 }

 function find_all_pages(){
      
   global $connection;

   $query = "SELECT * FROM pages ORDER BY position ASC ";
   $page_set = mysqli_query($connection, $query);

   confirm_query($page_set);
     return $page_set;
 }

 function find_pages_for_subjects($subject_id, $public=true){

    global $connection;
   
   $safe_subject_id =mysqli_real_escape_string($connection,$subject_id);

   $query = "SELECT * FROM pages ";
   $query .= "WHERE subject_id = {$safe_subject_id} ";
   if($public){
      $query .= "AND visible = 1 ";
   }
   $query .= "ORDER BY position ASC ";

   $page_set = mysqli_query($connection, $query);
   
   confirm_query($page_set);
    return $page_set;
 }

 function find_subject_id($subject_id, $public=true){
  
   global $connection;

 $safe_subject_id =mysqli_real_escape_string($connection,$subject_id);

   $query = "SELECT * FROM subjects ";
   $query .= "WHERE id = {$safe_subject_id} ";
   if($public){
      $query .= "AND visible = 1 ";
   }
   $query .= "LIMIT 1 ";
   $subject_set = mysqli_query($connection,$query);
   confirm_query($subject_set);
    if($subject = mysqli_fetch_assoc($subject_set)){
       return $subject;
    }else {
       return null;
    }

 }

 function find_page_id($page_id, $public=true){
       global $connection;

       $safe_page_id = mysqli_real_escape_string($connection,$page_id);

   $query = "SELECT * FROM pages ";
   $query .= "WHERE id = $safe_page_id ";
   if($public){
      $query .= "AND visible = 1 ";
   }
   $query .= "LIMIT 1 ";
    $page_set = mysqli_query($connection,$query);
     confirm_query($page_set);
     if($page = mysqli_fetch_assoc($page_set)){
        return $page;
     }else{
        return null;
     }
 }

  function find_default_page_for_subject($subject_id){

    $page_set = find_pages_for_subjects($subject_id);
      if($first_page = mysqli_fetch_assoc($page_set)){
         return $first_page;
      } else{
         return null;
         }
  }

 function find_select_page_or_subject_if_isset($public=false){
      global $current_page;
      global $current_subject;
      global $select_page_id;
      global $select_subject_id;

   if(isset($_GET["subject"])){
      $select_subject_id = $_GET["subject"];
$current_subject = find_subject_id($select_subject_id, $public);
 if($current_subject && $public){
    $current_page = find_default_page_for_subject($current_subject["id"]);
 }else{
    $current_page = null;
 }
  $select_page_id = null;
  }elseif(isset($_GET["page"])){
      $select_page_id = $_GET["page"]; 
$current_page = find_page_id($select_page_id, $public);
      $select_subject_id = null;
      $current_subject = null;
  }else{
      $select_subject_id = null;
      $select_page_id = null;
      $current_page = null;
      $current_subject = null;
  }
  return $current_page;
  return $current_subject;
 }

 function form_errors($errors = array()){
        
   $output = "";
if(!empty($errors)){
    $output .= "<div class=\"error\">";
    $output .= "Please fix the following errors";
    $output .= "<ul>";
foreach ($errors as $key => $error){
    $output .= "<li>{$error}</li>";
}
 $output .= "<ul>";
 $output .= "</div>";
}
return $output;
}

  function password_encrypt($password){

   $hash_format = "$2y$10$";
   $salt_length = 22;
   $salt = generate_salt($salt_length);
   $hash_format_and_salt = $hash_format . $salt;
   $hashed = crypt($password, $hash_format_and_salt);

   return $hashed;
  }

  function generate_salt($length){

    $unique_random_string = md5(uniqid(mt_rand(), true));

    $base64_string = base64_encode($unique_random_string);

    $modified_base64_string = str_replace('+', '.', $base64_string);

    $salt = substr($modified_base64_string, 0, $length);
 
    return $salt;
  }

  function password_checked($password, $existing_hash){

     $hashed = crypt($password, $existing_hash);

     if($hashed === $existing_hash){
        return true;
     }else{
        return false;
     }
  }

  function find_users_by_username($username){
     global $connection;

   $safe_username = mysqli_real_escape_string($connection, $username);

   $query = "SELECT * FROM users WHERE username = '{$safe_username}' LIMIT 1 ";
   $result_query = mysqli_query($connection, $query);
   if(!$result_query){
     die("DATABASE FAILED! " . mysqli_error($connection));
   }
   if($users = mysqli_fetch_assoc($result_query)){
      return $users;
   }else{
      return null;
   }
  }

 function attempt_login($username, $password ){
   $users = find_users_by_username($username); 
   
   if($users){
      // found users, now check password
      if(password_checked($password, $users["password"])){
         // password matched
         return $users;
      }else{
         // password does not matched
         return false;
      }
   }else{
      // users not found
      return false;
   }

 }
 
 function logged_in(){
    
  return isset($_SESSION["user_id"]);
 }
 function confirm_logged_in(){

   if(!logged_in()){
      redirect_to("login.php");
  }
 }



?>
 