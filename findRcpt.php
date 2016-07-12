<?php

    session_start();
 //   if (isset($_SESSION['uid']))
 //    {

 //       echo "<br> Session is set. <br>" ;
 //    }
     if (isset($_SESSION['uid']) == 0)
     {
       header('Location: http://getmymedicine.in/gmmadmin/adminLogin.htm?url=findRcpt1.php');     
     }   

  
function findReceipt($order_id) {

     $servername = "localhost";
     $username = "getmyeja_abc";
     $password = "9DauPnkn%";
     $dbname = "getmyeja_userDB";

  try {
         $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

     
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $findOrderSQL = "SELECT rcpt_id from receipt where ord_id = $order_id" ;
         echo $findOrderSQL ;
         $count = 0 ;
         $url = "Location: http://getmymedicine.in/gmmadmin/findRcpt1.php" ;
         foreach ($conn->query($findOrderSQL) as $row) {
               $url1 .= " " ;
               $rcpt_id = $row['rcpt_id'];
               $url1 .= "<a href=http://getmymedicine.in/gmmadmin/editReceipt.php?rcpt_id=" ;
               $url1 .= $rcpt_id ;
               $url1 .= ">$rcpt_id</a>";
           $count = $count+1;
         }  
    

          // $url .= urlencode($url1) ;
      

         if ($count > 0) {         

            $_SESSION['rcptList'] = $url1 ;
            $_Session['fc'] = 0 ;

            header($url) ;
            return 1 ;
         }
         else
         {
            $_SESSION['rcptList'] = -1;
            echo "<br> No records to show" ;
            $url = "Location: http://getmymedicine.in/gmmadmin/findRcpt1.php?rcpt_id=-1" ;
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
    $oid = $_POST["OrderID"];
    echo "Order Id is : $oid <br>";
if (isset($_POST["OrderID"])) {
    $oid = $_POST["OrderID"];
    echo "Order Id is : $oid <br>";
    $result = findReceipt(intval($_POST["OrderID"]));
    echo $result ;
}
else {
   $result = findReceipt(intval(3)); ;
   echo $result ;
    
}
?>