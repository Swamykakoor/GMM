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

     if($_POST['update_customer'] == "Add Order")
     {
       $phone = $_POST["Phone"]; 
       header("Location: http://getmymedicine.in/gmmadmin/AddRecords.php?id=$phone");
       return 1;
     }


function updateCustomer() {

  $servername = "localhost";
  $username = "getmyeja_abc";
  $password = "9DauPnkn%";
  $dbname = "getmyeja_userDB";

  try {
         $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

     
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $blank ;
         $fname = $_POST["Name"] ;
         $phone = $_POST["Phone"]; 
         $blank ;  
         $yob = $_POST["YOB"] ;  
         
         $aphone = $_POST["APhone"] ;
         $aphone=($aphone == $blank) ? 0 : $aphone ;  
         $email = $_POST["email"] ;  
         $address = $_POST["Address"] ;  
         $city = $_POST["City"] ;  
         $pin = $_POST["Pincode"] ;  
         $pin = ($pin == $blank) ? 0 : $pin ;
         $allergies = $_POST["Allergies"] ;  
         $ma = $_POST["MA"] ;  
         $pn = $_POST["PName"] ;  
         $pphone = $_POST["PPhone"] ; 
         $pphone = ($pphone == $blank) ? 0 : $pphone ; 
         $aliments = $_POST["ailments"];

         $updateCustSQL = "update customer_user set first_name = '$fname', yob=$yob, altphone=$aphone, email='$email', city='$city', zipcode=$pin, physician_name='$pn', physician_phone=$pphone, allergies='$allergies',ailments='$ma' where phone = $phone " ;
     //    echo "String is $updateCustSQL" ;
         $conn->exec($updateCustSQL);
         header("Location: http://getmymedicine.in/gmmadmin/editCustomer.php?id=$phone&updtd=1");         
      //   echo "Done";
    }
    catch(PDOException $e)
    {
         echo "Database Error : " . $e->getMessage();
         echo "<br>" ;
         header("Location: http://getmymedicine.in/gmmadmin/editCustomer.php?id=-1&updtd=1");

    }
    return -1;

}

if (isset($_POST['Phone'])) {
   updateCustomer();

}
else {
  // $result = findCustomer(intval(3)); 
   echo "Yo Swamy2" ;
    
}
?>