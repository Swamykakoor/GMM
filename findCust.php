<?php

    session_start();
 //   if (isset($_SESSION['uid']))
 //    {

 //       echo "<br> Session is set. <br>" ;
 //    }
     if (isset($_SESSION['uid']) == 0)
     {
       header('Location: http://getmymedicine.in/gmmadmin/adminLogin.htm?url=findCust1.php');     
     }   

  
function findCustomer($phoneNumber) {

     $servername = "localhost";
     $username = "getmyeja_abc";
     $password = "9DauPnkn%";
     $dbname = "getmyeja_userDB";

  try {
         $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

     
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $chkCustSQL = 'SELECT act_id from customer_user where phone =' ;
         $chkCustSQL .= $phoneNumber; 
         

         $rs = $conn->query($chkCustSQL);

         $urll = 'Location: http://getmymedicine.in/gmmadmin/findCust.php?PHPSESSID=';


         if ($rs->rowCount() > 0) {         

            $_SESSION["phone"] = $phoneNumber ;
            $_Session['fc'] = 0 ;
            $url = "Location: http://getmymedicine.in/gmmadmin/editCustomer.php?id=" ;
            $url .= $phoneNumber ;
            header($url) ;
            return 1 ;
         }
         else
         {
           $_Session['fc'] = $phoneNumber ; 
           $pc1 = $_Session['fc'] ;
          
            $url = 'Location: http://getmymedicine.in/gmmadmin/findCust1.php?fc=';
            $url .= $pc1 ;
            echo "URL IS : $url" ;
            header($url) ;
            
            $url = "<br> Customer does not exist in the DB. Click <a href=" ;
            $url .= "http://getmymedicine.in/gmmadmin/AddCustomer.php?phone=" ;
      
            $url .= $phoneNumber ;
            $url .= ">here</a> to add.<br> " ;
            echo $url ;
      //      header('Location: http://getmymedicine.in/gmmadmin/findCust1.php') ;
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