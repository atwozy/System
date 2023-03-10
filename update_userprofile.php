<?php

include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];


if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_contact = mysqli_real_escape_string($conn, $_POST['update_contact']);
   $update_location = mysqli_real_escape_string($conn, $_POST['update_location']);
   $update_bio = mysqli_real_escape_string($conn, $_POST['update_bio']);

   mysqli_query($conn, "UPDATE `sining_artists` SET artistName = '$update_name', artistContact ='$update_contact', artistLocation = '$update_location', artistBio = '$update_bio' WHERE artistId = '$user_id'") or die('query failed');
   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `sining_artists` SET artistProfile = '$update_image' WHERE artistId = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated succssfully!';
      }
   }
   $update_cover = $_FILES['update_cover']['name'];
   $update_cover_size = $_FILES['update_cover']['size'];
   $update_cover_tmp_name = $_FILES['update_cover']['tmp_name'];
   $update_cover_folder = 'cover/'.$update_cover;

   if(!empty($update_cover)){
      if($update_cover_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $cover_update_query = mysqli_query($conn, "UPDATE `sining_artists` SET artistCover = '$update_cover' WHERE artistId = '$user_id'") or die('query failed');
         if($cover_update_query){
            move_uploaded_file($update_cover_tmp_name, $update_cover_folder);
         }
         $message[] = 'image updated succssfully!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href=" css/updateprofile.css">
</head>

<body>
   
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistId = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['artistProfile'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src=" img/'.$fetch['artistProfile'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>Profile Picture :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box"><br><br><br>
            <span>Cover Photo :</span>
            <input type="file" name="update_cover" accept="image/jpg, image/jpeg, image/png" class="box"><br><br><br>
            <span>Username :</span>
            <input type="text" name="update_name" value="<?php echo $fetch['artistName']; ?>" class="box"><br>
            <span>Contact :</span>
            <input type="text" name="update_contact" value="<?php echo $fetch['artistContact']; ?>" class="box"><br>
            <span>Location :</span>
            <input type="text" name="update_location" value="<?php echo $fetch['artistLocation']; ?>" class="box"><br>
         </div>
         <div class="inputBox"><br><br><br><br><br><br>
         <span>Bio :</span>
            <input type="text" name="update_bio" value="<?php echo $fetch['artistBio']; ?>" class="box"><br>
         </div>
      </div>
      <div class="buttons">
         <input type="submit" value="UPDATE" name="update_profile" class="btn">
         <a href="userprofile.php" class="btn">BACK</a>
      </div>
      
   </form>
   

</div>

</body>
</html>