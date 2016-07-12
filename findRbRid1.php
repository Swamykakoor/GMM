<?php

    session_start();
 //   if (isset($_SESSION['uid']))
 //    {

 //       echo "<br> Session is set. <br>" ;
 //    }
     if (isset($_SESSION['uid']) == 0)
     {
       header('Location: http://getmymedicine.in/gmmadmin/adminLogin.htm?url=findRbRid.php');     
     }   

function findReceipt($rcpt_id) {

     $servername = "localhost";
     $username = "getmyeja_abc";
     $password = "9DauPnkn%";
     $dbname = "getmyeja_userDB";

   

  try {
         $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

     
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $findRcptSQL = "SELECT rcpt_id from receipt where rcpt_id = $rcpt_id" ;
         echo $findRcptSQL ;
         $count = 0 ;
         $url = "Location: http://getmymedicine.in/gmmadmin/editReceipt.php?rcpt_id=" ;
         echo "SQL is : $findRcptSQL";

         foreach ($conn->query($findRcptSQL) as $row) {
               $rcpt_id = $row['rcpt_id'];
               $url .= $rcpt_id ;
               echo $url;
               header($url);
           $count = $count+1;
         }  
         if ($count < 1) {        
             $_SESSION['rcptList'] = -1;
            $url = "Location: http://getmymedicine.in/gmmadmin/findRbRid.php?rcpt_id=-1" ;
            header($url) ;
            return -1 ;
         }

     }
     catch(PDOException $e)
     {
         echo "Database Error : " . $e->getMessage();
         echo "<br>" ;
         header('http://google.com/') ;

     }

    return -1;

}

if (isset($_POST["rcptID"])) {
    $rcptID = $_POST["rcptID"];
    echo "Receipt Id is : $rcptID <br>";
    $result = findReceipt($rcptID);
    echo $result ;
}
else {
   $result = findReceipt(intval(3)); ;
   echo $result ;
    
}
?>