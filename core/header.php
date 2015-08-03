<?php

 //error_reporting(E_ALL);
 //ini_set("display_errors", 1);

if(!isset($app)){
session_start();

header("Content-Type: text/html; charset=utf-8");
include("connectionDatabase.php");
include("dbclass.php");
include("user.php");
include("pubClass.php");

$app=new app();
$sessionuser=new user();
$pubfunclass=new pubClass();

if(!$app->PConnect("localhost","offerudb","offerudbuser","dMyDFbpy48Gyw76r")){

   $app->writetolog("can not connect to db  ");
   $app->isconnected=false;

 }else {

   $app->isconnected=true;
   $app->convertosecureparemters($_POST);
   set_error_handler(array($app, 'appErrorHandler'));
   $sessionuser->setapp($app);
   $pubfunclass->setapp($app);

   if(isset($_SESSION['userid'])){

     $app->userid=$_SESSION['userid'];
     if(isset($app->paremters['f'])) {
       $f=$app->paremters[f]; 
     if($f!=""){ 
      $funcname=$app->execute($f);
      call_user_func(array($pubfunclass, $funcname));
      
      } 
}

     if($app->userid>0)
         $sessionuser->load($app->userid);
     
   } else {

      $f="";
      if(isset($app->paremters['f'])) $f=$app->paremters[f]; 
      if($f!=""){ 
      $funcname=$app->execute($f);
      call_user_func(array($pubfunclass, $funcname));
      
      } else if(isset($_GET['f'])) {
        $app->convertosecureparemters($_GET);
      if(isset($app->paremters['f'])) $f=$app->paremters[f]; 
     if($f!=""){ 
        $funcname=$app->execute($f);
       call_user_func(array($pubfunclass, $funcname));
      }

       }

     }



  }



 }




?>
