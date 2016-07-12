<?php

    session_start();
 //   if (isset($_SESSION['uid']))
 //    {

 //       echo "<br> Session is set. <br>" ;
 //    }
     if (isset($_SESSION['uid']) == 0)
     { 
       
       header('Location: http://getmymedicine.in/gmmadmin/adminLogin.htm');     
     }   

function uploadFile($file,$dstnFile)
{
   $target_dir = "/home/getmyeja/uploads/receipts/";
   $target_file = $target_dir . $dstnFile;
   $uploadOk = 1;
   echo "<br>Source file is : $file Target file is : $target_file" ;
   $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
   // Check if image file is a actual image or fake image
//   if(isset($_POST["submit"])) {
       
       $check = getimagesize($_FILES["file"]["tmp_name"]);
       if($check !== false) {
           echo "<br>File is an image - " . $check["mime"] . ".";
           $uploadOk = 1;
       } else {
           echo "<br>File is not an image.";
           $uploadOk = 0;
      }
   // Check if file already exists
   if (file_exists($target_file)) {
      echo "<br> Sorry, file already exists.";
      $uploadOk = 0;
   }
   // Check file size
   if ($_FILES["file"]["size"] > 500000) {
      echo "<br> Sorry, your file is too large.";
      $uploadOk = 0;
   }
   // Allow certain file formats
   if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
      echo "<br> Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
   }
   // Check if $uploadOk is set to 0 by an error
   if ($uploadOk == 0) {
       echo "<br>Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
   } else {
       if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
           echo "The file ". basename( $_FILES["rcfile"]["name"]). " has been uploaded.";
     } else {
           echo "<br>Sorry, there was an error uploading your file.";
     }
  }

}

function updateReceipt($rcpt_id) {

  $servername = "localhost";
  $username = "getmyeja_abc";
  $password = "9DauPnkn%";
  $dbname = "getmyeja_userDB";

  try {


         $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

     
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $blank ;
       
         $itmid = $_POST["ItemId"] ;
         $ffdate = $_POST["ffDate"] ;
         $fftime = $_POST["ffTime"] ;

         $medname = $_POST["medName"] ;
         $provider = $_POST["provider"];
         $amount = $_POST["Amount"];
         $rcptimg = $_FILES['file']['name'];
         $rcptnotes = $_POST["rcptDetails"];
         $del_id = $_POST["delvid"];
         $rcvr_name = $_POST["rcvr"];  
         $old_fname = $_POST["old_fname"];


         $dstn = $rcpt_id . rand(1,1000) . ".jpg" ; 
         $blank;
         $newf = $rcptimg;
         echo "<br> Old is [$old_fname] New is : [$newf] <br>";
         if($newf != $blank && $old_fname != $_POST["rcfile"])         
           uploadFile($rcptimg,$dstn);
         else
           $dstn = $old_fname;

         $updateReceiptSQL = "update receipt set med_name = '$medname', provider='$provider', amount=$amount, rcpt_image='$dstn', notes='$rcptnotes', deliverer_id='$del_id', rcvr_name = '$rcvr_name' where rcpt_id = $rcpt_id" ;
      
         echo "<br> SQL is : $updateReceiptSQL <br>" ;
         $conn->exec($updateReceiptSQL);

         header("Location: http://getmymedicine.in/gmmadmin/editReceipt.php?rcpt_id=$rcpt_id&updtd=1");         
      
    }
    catch(PDOException $e)
    {
         echo "Database Error : " . $e->getMessage();
         echo "<br>" ;
         header("Location: http://getmymedicine.in/gmmadmin/editReceipt.php?rcpt_id=-1&updtd=1");

    }
    return -1;

}
$rcpt_id = $_POST["rcpt_id"]; 
if (isset($_POST["rcpt_id"])) {
   updateReceipt($rcpt_id);

}
else {
  // $result = findCustomer(intval(3)); 
   echo "Yo Swamy2" ;
    
}
?>