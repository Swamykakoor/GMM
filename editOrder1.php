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
   $target_dir = "/home/getmyeja/uploads/orders/";
   $target_file = $target_dir . $dstnFile;
   $uploadOk = 1;
   echo "<br>Target file is : $target_file" ;
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
           echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
     } else {
           echo "<br>Sorry, there was an error uploading your file.";
     }
  }

}

function updateOrder($order_id) {

  $servername = "localhost";
  $username = "getmyeja_abc";
  $password = "9DauPnkn%";
  $dbname = "getmyeja_userDB";

  try {

       $t = $_POST['update_order'] ;

       
           
       if($t == 'Add Receipt')
       {      
         $order_id = $_POST["order_id"]; 
         
         header("Location: http://getmymedicine.in/gmmadmin/AddReceipt.php?order_id=$order_id");
         return 1;
       }
       
         $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

     
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($t == 'Close Order')
        {
          $conn->exec("updated Orders set order_status='C' where order_id = $order_id") ;
          header("Location: http://getmymedicine.in/gmmadmin/editOrder.php?order_id=$order_id&updtd=2");  
        }
          $blank ;
          $aphone = $_POST['altphone'] ;
          $aphone = ($aphone == $blank) ? 0 : $aphone ;
          $address = $_POST['Address'] ;
          $doc_name = $_POST['PName'] ;
          $doc_address = $_POST['doc_address'] ;
          $doc_phone= $_POST['PPhone'] ;
          $doc_phone = ($doc_phone == $blank) ? 0 : $doc_phone ;
          $order_status = $_POST['order_status'] ;
          $ps_image = $_POST['PrescriptionFil'] ;
          $order_details = $_POST['ordDetails'] ;
          $tags = $_POST['tags'] ;

          $dstn = $order_id . rand(1,1000) . ".jpg" ; 
    
         uploadFile($ps_image,$dstn);
         $updateOrderSQL = "update Orders set aphone = $aphone, address='$address', doc_name='$doc_name', doc_phone=$doc_phone, ps_image='$dstn', order_details = '$order_details' where order_id = $order_id" ;

         $conn->exec($updateOrderSQL);

         header("Location: http://getmymedicine.in/gmmadmin/editOrder.php?order_id=$order_id&updtd=1");         
      
    }
    catch(PDOException $e)
    {
         echo "Database Error : " . $e->getMessage();
         echo "<br>" ;
         header("Location: http://getmymedicine.in/gmmadmin/editOrder.php?order_id=-1&updtd=1");

    }
    return -1;

}
$order_id = $_POST["order_id"]; 
if (isset($_POST["order_id"])) {
   updateOrder($order_id);

}
else {
  // $result = findCustomer(intval(3)); 
   echo "Yo Swamy2" ;
    
}
?>