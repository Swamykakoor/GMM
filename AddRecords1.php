<?php

    session_start();
 //   if (isset($_SESSION['uid']))
 //    {

 //       echo "<br> Session is set. <br>" ;
 //    }
     if (isset($_SESSION['uid']) == 0)
     { 
       
       header('Location: http://getmymedicine.in/gmmadmin/adminLogin.php?url=AddRecords.php');     
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
function createOrder($phone) {

  $servername = "localhost";
  $username = "getmyeja_abc";
  $password = "9DauPnkn%";
  $dbname = "getmyeja_userDB";

  try {

           $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

         // set the PDO error mode to exception
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $chkCustSQL = 'SELECT act_id from customer_user where phone =' ;
         $chkCustSQL .= $phone ; 
   
          echo $chkCustSQL ;
         $rs = $conn->query($chkCustSQL);
         $act_id  = $rs->fetchColumn();
 //        echo "Account ID is : $act_id" ;

         echo $act_id;
         if ($act_id == 0)
         {
           
            $url = "<br> There are no users with this phone number. Click <a href=" ;
            $url .= "http://getmymedicine.in/gmmadmin/AddCustomer.php?phone=" ;
      
            $url .= $phone ;
            $url .= ">here</a> to add a new customer.<br> " ;
            echo $url ;
 
     //       header("Location : http://getmymedicine.in/gmmadmin/AddRecords.php?id=-1");
    //        header($urll) ;
   //         echo "Yo! Heading back" ;
              return -1; 

         }            
          
         $ord_date = $_POST["OrdDate"] ;
         $ord_time = $_POST["OrdTime"] ;

         $ord_details1 = $_POST["ordDetails"] ;
         $ord_details = strip_tags(trim($ord_details1));

         $address = $_POST["Address"] ;
         $altphone = $_POST["altphone"] ;
         $doc_phone = $_POST["PPhone"];
         $doc_name = $_POST["PName"] ;
         $file = $_POST["file"] ;
         $tags = $_POST["Tags"] ;
         $aphone = $_POST["altphone"];
         
         echo "File name is : $file </br>" ;
         uploadFile($file,$ord_id);
         $addOrderSQL = 'insert into Orders(ord_act_id,ord_date,order_time, order_details,address,phone,doc_name,doc_phone,ps_image, tags,aphone,order_status)    values (' ;

         $addOrderSQL .= $act_id . ", '" . $ord_date . "','" . $ord_time . "', '" . $ord_details . " ' ,' " . $address . " ' ," . $phone . ",'" . $doc_name . "', '" . $doc_phone . " ' , ' " . $file . "', '" . $tags . "','$aphone','O' )" ; 

           echo $addOrderSQL;
           $conn->exec($addOrderSQL);
           $ord_id = $conn->lastInsertId () ; 
           $dfname = $ord_id . ".jpg" ;
           uploadFile($file,$dfname);
           $qry = "update Orders set ps_image='$dfname' where order_id = $ord_id" ;
           echo "<br> Update query is : $qry" ;
           $statement = $conn->prepare($qry);
           $statement->execute();
           $_SESSION["oid"] = $ord_id ;   
           header("Location: http://getmymedicine.in/gmmadmin/AddRecords.php?order_id=$ord_id");         
      
    }
    catch(PDOException $e)
    {
         echo "Database Error : " . $e->getMessage();
         echo "<br>" ;
        // header("Location: http://getmymedicine.in/gmmadmin/AddRecords.php?order_id=-1");

    }
    return -1;

}

if (isset($_POST["CustomerPhone"])) {
   
   createOrder($_POST["CustomerPhone"]); 
}
else {
  // $result = findCustomer(intval(3)); 
   echo "Yo Swamy2" ;
    
}
?>