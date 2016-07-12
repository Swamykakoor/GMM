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

  
function findCustomer($phoneNumber) {

     $servername = "localhost";
     $username = "getmyeja_abc";
     $password = "9DauPnkn%";
     $dbname = "getmyeja_userDB";

  try {
         $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

     
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $findOrderSQL = "SELECT order_id from Orders where phone = $phoneNumber and order_status='O'" ;
       
         $count = 0 ;
         $url = "Location: http://getmymedicine.in/gmmadmin/fobCust1.php" ;
         foreach ($conn->query($findOrderSQL) as $row) {
               $url1 .= " " ;
               $order_id = $row['order_id'];
               $url1 .= "<a href=http://getmymedicine.in/gmmadmin/editOrder.php?order_id=" ;
               $url1 .= $order_id ;
               $url1 .= ">$order_id</a>";
           $count = $count+1;
         }  
    

          // $url .= urlencode($url1) ;
      

         if ($count > 0) {         

            $_SESSION['orderList'] = $url1 ;
            $_Session['fc'] = 0 ;

            header($url) ;
            return 1 ;
         }
         else
         {
            $_SESSION['orderList'] = -1;
          //  $url = 'Location: http://getmymedicine.in/gmmadmin/fobCust1.php?order_id=-1" ;
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

if (isset($_POST['phoneNumber'])) {
    $result = findCustomer(intval($_POST['phoneNumber']));
    echo $result ;
}
else {
   $result = findCustomer(intval(3)); ;
   echo $result ;
    
}
?>