<?php

    session_start();

     if (isset($_SESSION['uid']) == 0)
     { 
       
       header("Location: http://getmymedicine.in/gmmadmin/adminLogin.php?url=AddCustomer.php");     
     }   
     if(($_SERVER['REQUEST_METHOD'] != 'POST'))
     {
       echo "Invalid operation. Your request should not have reached this code. Please login again and re-try the operation!";
       header("Location: http://getmymedicine.in/gmmadmin/adminLogin.php?url=AddCustomer.php");  
     }

     $servername = "localhost";
     $username = "getmyeja_abc";
     $password = "9DauPnkn%";
     $dbname = "getmyeja_userDB";

     $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

          
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     echo "Connection Done" ;

     $GLOBALS['phone'] = $_POST["Phone"];


   if(!checkCustomer())
   {
     echo "Customer does not exist <br>" ;
    
     addCustomer();
     echo "Done adding the customer <br> " ;
     header("Location: http://getmymedicine.in/gmmadmin/AddCustomer.php?uid=1&phone=$phone");    
   }
   else
   {
     echo "Customer exists" ;
     header("Location: http://getmymedicine.in/gmmadmin/AddCustomer.php?uid=-1&phone=$phone");    

   }


function checkCustomer() {

  echo "<br> In checkCustomer" ;
  try {
         $blank ;
         $phone = $_POST["Phone"] ;
         $chkCustSQL = 'SELECT act_id from customer_user where phone =' ;
         $chkCustSQL .= $phone ; 

         echo "In checkCustomer8 <br>" ;
         $rs = $GLOBALS[conn]->query($chkCustSQL);
         echo "In checkCustomer1" ;
         $ssn = session_id() ;
         echo "In checkCustomer2" ;
         
         if ($rs->rowCount() > 0) {
             echo "In checkCustomer 3" ;
             return 1;
         }
         else
         {
            echo "In checkCustomer4" ;
            return 0 ;

         }
    }
    catch(PDOException $e)
    {
         echo "Database Error : " . $e->getMessage();
         echo "<br>" ;
         header("Location: http://getmymedicine.in/gmmadmin/AddCustomer.php/uid=-2");
         return -1; 
    }
    return -1;

}

function addCustomer() {
   
   try {
    $servername = "localhost";
     $username = "getmyeja_abc";
     $password = "9DauPnkn%";
     $dbname = "getmyeja_userDB";

     $conn1 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

          
     $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Read form data
            $fname = $_POST["Name"] ;      
            $yob = $_POST["YOB"] ;  
            $phone1 = $_POST["Phone"] ;
            $aphone = $_POST["APhone"] ;  
            $email = $_POST["email"] ;  
            $address = $_POST["Address"] ;  
            $city = $_POST["City"] ;  
            $pin = $_POST["Pincode"] ;  
            $allergies = $_POST["Allergies"] ;  
            $ma = $_POST["MA"] ;  
            $pn = $_POST["PName"] ;  
            $pphone = $_POST["PPhone"] ;  

            echo "Sw0" ;
            $st1 = $conn1->prepare('insert into customer_master values()');
            echo "Sw01" ;
            $st1->execute();
            echo "Sw02" ;
            $act_id = $conn1->lastInsertId () ;   
            echo "Account ID is  : $act_id";
             echo "Sw1" ;

            $addCustSQL = 'insert into customer_user(act_id,first_name,yob,address1,city,zipcode,phone,email,physician_name,physician_phone,allergies,ailments,altphone) values (' ;

           $addCustSQL .= $act_id . ", '" . $fname . "'," . $yob . ", '" . $address . " ' ,' " . $city . " ' ," . $pin . "," . $phone1 . ", '" . $email . " ' , ' " . $pn . " ' ," . $pphone . ", ' " . $allergies . " ' , ' " . $ma . "'," . $aphone  . " )" ; 

           echo "<br> SQL is : $addCustSQL" ;
           $st2 = $conn1->prepare($addCustSQL);
           $st2->execute();
      
           echo "Done adding the customer" ;
   }
   catch(PDOException $e)
   {
         echo "Database Error : " . $e->getMessage();
         echo "<br>" ;
         header("Location: http://getmymedicine.in/gmmadmin/AddCustomer.php");

   }

   return -1;

}
 

?>