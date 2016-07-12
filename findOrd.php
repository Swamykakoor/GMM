<?php

    session_start();
 //   if (isset($_SESSION['uid']))
 //    {

 //       echo "<br> Session is set. <br>" ;
 //    }
     if (isset($_SESSION['uid']) == 0)
     {
       header('Location: http://getmymedicine.in/gmmadmin/adminLogin.php?url=findOrd1.php');     
     }   

  
function findOrder($order_id) {

     $servername = "localhost";
     $username = "getmyeja_abc";
     $password = "9DauPnkn%";
     $dbname = "getmyeja_userDB";

  try {
         $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

     
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $findOrderSQL = "SELECT order_id from Orders where order_id = $order_id " ;
         

         $rs = $conn->query($findOrderSQL);

         $urll = 'Location: http://getmymedicine.in/gmmadmin/findOrd.php?PHPSESSID=';


         if ($rs->rowCount() > 0) {         

            $_SESSION["order_id"] = $order_id ;
            $url = "Location: http://getmymedicine.in/gmmadmin/editOrder.php?order_id=$order_id" ;
            header($url) ;
            return 1 ;
         }
         else
         {
           $_Session['order_id'] = $order_id ; 
    
          
            $url = 'Location: http://getmymedicine.in/gmmadmin/findOrd1.php?order_id=-1' ;
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

if (isset($_POST['order_id'])) {
    $result = findOrder(intval($_POST['order_id']));
    echo $result ;
}
else {
   $result = findOrder(intval(3)); ;
   echo $result ;
    
}
?>