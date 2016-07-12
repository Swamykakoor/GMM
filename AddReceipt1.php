<?php

    session_start();
    if (isset($_SESSION['uid']) == 0)
    { 
       
      header('Location: http://getmymedicine.in/gmmadmin/adminLogin.php?url=AddReceipts.php');     
    }   
    if(($_SERVER['REQUEST_METHOD'] != 'POST'))
    {
       echo "Invalid operation. Your request should not have reached this code. Please login again and re-try the operation!";
       header("Location: http://getmymedicine.in/gmmadmin/adminLogin.php?url=AddCustomer.php");  
    }

function uploadRcptFile($file,$dstnFile)
{
   $target_dir = "/home/getmyeja/uploads/receipts/";
   $target_file = $target_dir . $dstnFile;
   $uploadOk = 1;
   echo "<br> Source file is : $file Target file is : $target_file" ;
   $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
   
   // Check if image file is a actual image or fake image
       
       $check = getimagesize($_FILES[$file]["tmp_name"]);
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
   if ($_FILES[$file]["size"] > 500000) {
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
       echo "<br>Sorry, your file was not uploaded due to an unknown error.";

   // if everything is ok, try to upload file
   } else {
       if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
           echo "The file ". basename( $_FILES[$file]["name"]). " has been uploaded.";
     } else {
           echo "<br>Sorry, there was an error uploading your file.";
     }
  }

}
function createReceipt($ord_id) {

  $servername = "localhost";
  $username = "getmyeja_abc";
  $password = "9DauPnkn%";
  $dbname = "getmyeja_userDB";

  try {

     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

     // set the PDO error mode to exception
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $chkOrderSQL = 'SELECT order_id from Orders where order_id =' ;
     $chkOrderSQL .= $ord_id ; 
   
  
     $rs = $conn->query($chkOrderSQL);
     $ord_id  = $rs->fetchColumn();
    
     if ($ord_id == 0)
     {
        $url = "<br> There are no Orders with this Order ID. Please create an order by clicking <a href=" ;
        $url .= "http://getmymedicine.in/gmmadmin/AddRecords.htm" ;
        $url .= ">here</a> .<br> " ;
        echo $url ;
        header("Location: http://getmymedicine.in/gmmadmin/AddReceipt.php?rcpt_id=-2"); 
        return -1; 

     }             
     $itmid = $_POST["ItemId"] ;
     $ffdate = $_POST["ffDate"] ;
     $fftime = $_POST["ffTime"] ;

     $medname = $_POST["medName"] ;
     $provider = $_POST["provider"];
     $amount = $_POST["amount"];
     $rcptimg = $_POST["rcfile"];
     $rcptnotes = $_POST["rcptDetails"];
     $dlvr = $_POST["delvid"];
     $rcvr = $_POST["rcvr"];
         
     $addRcptSQL = 'insert into receipt(ord_id,item_id,ff_date,ff_time, med_name,provider,amount,rcpt_image,notes,deliverer_id,rcvr_name)    values (' ;

     $addRcptSQL .= $ord_id . ", " . $itmid . ",'" . $ffdate . "', '" . $fftime . " ' ,' " . $medname . " ' ,' " . $provider . "'," . $amount . ", '" . $rcptimg . " ' , ' " . $rcptnotes . "',$dlvr,'" .$rcvr ."' )" ; 
  
     echo "<br> SQL is : $addRcptSQL <br>" ;
     $conn->exec($addRcptSQL);

     $rcpt_id = $conn->lastInsertId () ; 
     $dfname = $rcpt_id . ".jpg" ;

     uploadRcptFile("rcfile",$dfname);
     $qry = "update receipt set rcpt_image='$dfname' where rcpt_id = $rcpt_id" ;
   //  echo "<br> Update query is : $qry" ;
     $statement = $conn->prepare($qry);
     $statement->execute();
   //  echo "Receipt data stored successfully" ;   
     header("Location: http://getmymedicine.in/gmmadmin/AddReceipt.php?rcpt_id=$rcpt_id");              
    }
    catch(PDOException $e)
    {
      echo "Database Error : " . $e->getMessage();
      echo "<br>" ;
      header("Location: http://getmymedicine.in/gmmadmin/AddReceipts.php?rcpt_id=-1");

    }
    return -1;
}

if (isset($_POST["OrdId"])) {
   
   createReceipt($_POST["OrdId"]); 
}
else {
    header("Location: http://getmymedicine.in/gmmadmin/AddReceipts.php?rcpt_id=-1");
    return -1;    
}
?>