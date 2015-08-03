<?php
 ini_set('session.use_trans_sid', '0');
 include("core/header.php");
   if($sessionuser->getislogin())
         $pubfunclass->cklogout(); 
     
  header("location:index.php");
   
  
  

?>	
