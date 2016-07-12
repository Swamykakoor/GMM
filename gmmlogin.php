<?php



   $username = "getmyeja_abc";
   $password = "9DauPnkn%";  

   $un = $_POST["username"];
   $pw = $_POST["password"];
   $url = $_POST["url"]; 
   

   echo "un : $un pw=$pw  url = $url<br>" ;

   if($un == $username && $pw == $password)
   {
        echo "Login successful!" ;
        session_start();
        $_SESSION["uid"]  = $un ;

        echo "URL passed is $url";      
        header("Location: $url");
   }
   else
   {
       echo "Login failed! Please try again..." ;
       header('Location: http://getmymedicine.in/gmmadmin/adminLogin.php');
         
   }   

?>

