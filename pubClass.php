<?php

class pubClass extends dbclass{

      var $app;

      public function setapp($appobj){

           $this->app=$appobj;

      }


function getrefcount($refv){

         $query="select id,(select count(id) from users where reftoid=pr.id ) as countv from users as pr where pr.`ref`='".$refv."' ;" ; 
         $loadquery=$this->app->Executequery($query);
         if($userdata=mysql_fetch_assoc($loadquery))
             return $userdata;
           else return false;

      }


     function getuserbyrefregister($refv){

         $refv=strtolower($refv);
         $query="SELECT `id`, `fname`, `lname` FROM `users` WHERE `ref`='".$refv."' and state=1 and level=1 limit 1;" ; 
         $loadquery=$this->app->Executequery($query);
        if($userdata=mysql_fetch_assoc($loadquery)) return $userdata;
           else return false;

      }



  function getajax(){

         $refv=strtolower($this->app->paremters['refv']);
         $query="SELECT `id`, `fname`, `lname`,level FROM `users` WHERE `ref`='".$refv."' and state=1 limit 1;" ; 
         $loadquery=$this->app->Executequery($query);
         if($userdata=mysql_fetch_assoc($loadquery)){ 
           if($userdata["level"]==1)
            echo "Name : ".$userdata["fname"];
             else echo "Name : ".$userdata["fname"]." ,not Valide,Complete level";

         } else echo "Not Valide REf";

      }



 function getajaxtransfer(){

         $refv=strtolower($this->app->paremters['refv']);
         $query="SELECT `id`, `fname`, `lname` FROM `users` WHERE `ref`='".$refv."' and dataconfirm=1 and ecardtype!=0 limit 1;" ; 
         $loadquery=$this->app->Executequery($query);
         if($userdata=mbysql_fetch_assoc($loadquery)){ 
         echo "Name : ".$userdata["fname"];

         } else echo "Not Valide REf";


      }



function cklogin(){

 
 $usernametxt = $this->app->paremters['loginemail'];
 $userpassword=$this->app->paremters['password'];
 $this->app->saveaction(0,0,1,"cklogin");
 //try count 
 $query="SELECT `id`, `fname`,ecardtype  FROM `users` WHERE  password='$userpassword' and (email='$usernametxt' or ref='$usernametxt') and usertype!=3 and dataconfirm=1;" ; 
 $sqquery=$this->app->Executequery($query);
 if($sqquery){
 if($rowsdata=mysql_fetch_array($sqquery)) {
           //save to start session table 
           $this->userid=$rowsdata[0];
           $_SESSION['userid']=$rowsdata[0];
	   $_SESSION['securitylevel']=5;
	   $_SESSION['password']=$userpassword;
           $_SESSION['username']=$usernametxt;
	   $_SESSION['login']=1;
           $_SESSION['cardtype']=$rowsdata[2];
           $cardtype=$rowsdata[2];

          if($cardtype>1)
	   header("location:../profile.php");
           else  header("location:../ourproduct.php");
          
          return true; 
     } 
      //update try count 
   }

   $this->updatetrycount($usernametxt);
   $this->app->actionerro=1;
   $this->app->actionmsg="Invalide User Email Or Password !";
  // header("location:../login.html");
   return false; 

}


function updatetrycount($username){

         $query="update users set country=country+1 where username= '$username' limit 1;" ; 
         $loadquery=$this->app->Executequery($query);
       
      }

 
function cklogout(){
   //end session value
    $userid=$_SESSION['userid'];
    $this->app->saveaction($userid,$userid,18,"logOut"); 

    if(isset($_SESSION['userid']))$_SESSION['userid']=-1;
    if(isset($_SESSION['securitylevel']))$_SESSION['securitylevel']=0;
    if(isset($_SESSION['password']))$_SESSION['password']=-1;
    if(isset($_SESSION['login']))$_SESSION['login']=-1;
    session_destroy();
    return true;
   
}

//////////////////////////////////////////////////////////////////////////
 
function ckregister(){

 $this->app->saveaction(0,0,2,"ckregister");
 $userid=$this->app->userid;

 $firstname= $this->app->paremters['firstname'];
 $lastname= $this->app->paremters['lastname'];
 $homenumber= $this->app->paremters['homenumber'];
 $email= $this->app->paremters['email'];
 $tel= $this->app->paremters['mobilenumber'];
 $idtype= $this->app->paremters['idtype'];
 $idnumber= $this->app->paremters['idnumber'];
 $nationality= $this->app->paremters['nationality'];
 $passwallet= $this->app->paremters['pass_ew'];
 $repasswallet= $this->app->paremters['repass_ew'];

 $pass= $this->app->paremters['pass'];
 $repass=$this->app->paremters['repass'];

 $captcha= $this->app->paremters['captcha'];
 $cabstr=$_SESSION['captcha_id'];
if($cabstr!=$captcha){
  $this->app->actionmsg="Failed To register ,THe human readable image Not correct !";
  $this->app->actionerro=1;
  return false;

  }

 $gender= $this->app->paremters['gender'];
 $birthday= $this->app->paremters['birthday'];
 $address= $this->app->paremters['address'];
 $imageData = @getimagesize($_FILES["picture"]["tmp_name"]);

if($imageData === FALSE || !($imageData[2] == IMAGETYPE_JPG || $imageData[2] == IMAGETYPE_JPEG || $imageData[2] == IMAGETYPE_PNG)) {
   
  $this->app->actionmsg="Failed To register Please Check uploaded Id picture only (png,jpg,jpeg) !";
  $this->app->actionerro=1;

  return false;

}


 $idimage = addslashes(file_get_contents($_FILES['picture']['tmp_name'])); 
 $ref=strtolower($this->app->paremters['refv']);
 $refdata=$this->getrefcount($ref);

  $queryma="SELECT * FROM `users` WHERE  email='$email';" ; 
  $sqquerymail=$this->app->Executequery($queryma);
 if($sqquerymail){ 
 if($rowsdataaa=mysql_fetch_array($sqquerymail)) {
  $this->app->actionmsg="E-mail you entered already exist !";
  $this->app->actionerro=1;

  return false;
  }
 }
 

if($refdata!=false){

 $refid=$refdata['id'];
 $refidval=$refdata['countv'];
if($refidval<7) {
 $giden=$this->generateref(7);
 $query="INSERT INTO `users`(`fname`, `password`, `lname`, `email`, `tel`,`hometel`,`gender`,`useraddress`,`date_birth`,`idtype`,`idnumber`,`nationality`, `ref`, `refto`, `reftoid`, `usertype`,`idimage`,`passwordewallet`) values('$firstname','$pass','$lastname','$email','$tel','$homenumber','$gender','$address','$birthday','$idtype','$idnumber','$nationality','$giden','$ref','$refid','0','{$idimage}','$passwallet');" ;
  $sqquery=$this->app->Executequery($query);
  if($sqquery) {

           $regid=mysql_insert_id($this->app->ConId);
           $tempcode=md5($regid."offerucardbadrr");
           $this->app->actionerro=2;
           $this->app->actionmsg="Thanks For register with us ,we sent you mail please confirm your mail!";
           $msg="Thanks For Register With us <br/>";
           $msg=$msg."<a href='".$this->app->confirmatilurl."f=ckconfirmmail&email=".$email."&temp=".$tempcode."'> Click here to Confirm your email</a>";
           $this->app->sendmail($email,"Email Confirmation ",$msg);

          return true;
    }else $this->app->actionmsg="Failed To register Please Check Your Data and try again!";
   }else $this->app->actionmsg="Failed To register Please Check  Your Referal and try again!";  
  }else $this->app->actionmsg="Failed To register Please Check  Your Referal and try again !";
   

  $this->app->actionerro=1;
   
  return false;
 
}

function seterrormsg($msssg){

   $this->app->actionerro=1;
   $this->app->actionmsg=$msssg;

   return false;
}



 function getuserbyref($refv){

         $query="SELECT `id`, `fname`,`lname`  FROM `users` WHERE `ref`='".$refv."' limit 1;" ; 
         $loadquery=$this->app->Executequery($query);
        if($userdata=mysql_fetch_assoc($loadquery)) return $userdata;
         else return false;

      }


function ckconfirmmail(){

 $this->app->saveaction(0,0,3,"ckconfirmmail");
 $email = $this->app->paremters['email'];
 $temp=$this->app->paremters['temp'];

 $query="SELECT `id`, `fname`,`lname`,ecardtype  FROM `users` WHERE  email='$email' and dataconfirm=0;" ; 
 $sqquery=$this->app->Executequery($query);
 if($sqquery){
 if($rowsdata=mysql_fetch_array($sqquery)) {
           $useridval=$rowsdata[0];
           $tempcode=md5($useridval."offerucardbadrr");

           if($tempcode==$temp){

           $this->updatedataconfirm($useridval);
           $_SESSION['userid']=$rowsdata[0];
	   $_SESSION['securitylevel']=5;
	   $_SESSION['password']=$userpassword;
           $_SESSION['username']=$usernametxt;
	   $_SESSION['login']=1;
           $_SESSION['cardtype']=$rowsdata[3];
           $cardtype=$rowsdata[2];

          if($cardtype>1)
	      header("location:../profile.php");
           else  header("location:../shop.php");
          
            return true; 

          }
       }  
   }

   $this->updatetrycount($email);
   $this->app->actionerro=1;
   $this->app->actionmsg="Invalide User Email Or TempCode !";
 
  return false;
 
 }



 function updatedataconfirm($userid){

         $query="update users set dataconfirm='1' where id= '$userid' limit 1;" ; 
         $loadquery=$this->app->Executequery($query);
       
   }




function ckforgetpass(){


 $this->app->saveaction(0,0,34,"ckforgetpass");

 $email = $this->app->paremters['forgetemail'];
 $captcha= $this->app->paremters['captcha'];
 $cabstr=$_SESSION['captcha_id'];
 if($cabstr!=$captcha){
  $this->app->actionmsg="Failed To register ,THe human readable image Not correct !";
  $this->app->actionerro=1;
  return false;

  }

 $query="SELECT `id`, `fname`,`lname`,ecardtype,password  FROM `users` WHERE  email='$email' and dataconfirm=1 and usertype!=3;" ; 
 $sqquery=$this->app->Executequery($query);
 if($sqquery){
 if($rowsdata=mysql_fetch_array($sqquery)) {

           $useridval=$rowsdata[0];
           $passwordv=$rowsdata[4];
           $tempcode=md5($useridval."offerucardbadrrresetpass".$passwordv);
           $this->app->actionerro=2;
           $this->app->actionmsg="Thanks For register with us ,we sent you mail to can reset Your password!";
           $msg="Thanks For Register With us <br/>";
           $msg=$msg."<a href='".$this->app->resetpassurl."f=ckupdatepass&email=".$email."&temp=".$tempcode."'> Click here to reset your Password</a>";
           $this->app->sendmail($email,"Password Reset ",$msg);

          return true;

          }
   }

   $this->updatetrycount($email);
   $this->app->actionerro=1;
   $this->app->actionmsg="Invalide User Email !";
 
  return false;
 
 }



function ckupdatepass(){

 $this->app->saveaction(0,0,44,"ckupdatepass");
 
 if(!isset($this->app->paremters['password'])){

if(isset($this->app->paremters['temp'])){

  $_SESSION['temp']=$this->app->paremters['temp'];
  $_SESSION['email']=$this->app->paremters['email'];
  $this->app->actionmsg="Write Your New password to reset the old one  !";
  $this->app->actionerro=2;

  }else   header("location:login.php");

  return true;
 }
 else {

 $email = $_SESSION['email'];
 $temp = $_SESSION['temp'];
 }
 

 $npass = $this->app->paremters['password'];
 $confnpass = $this->app->paremters['confpassword'];

 $query="SELECT `id`, `fname`,`lname`,ecardtype,password  FROM `users` WHERE  email='$email' and dataconfirm=1 and usertype!=3;" ; 
 $sqquery=$this->app->Executequery($query);
 if($sqquery){
 if($rowsdata=mysql_fetch_array($sqquery)) {
           $useridval=$rowsdata[0];
           $passwordv=$rowsdata[4];
           $tempcode=md5($useridval."offerucardbadrrresetpass".$passwordv);
          
          if($tempcode==$temp){

           $this->updatepass($useridval,$npass);
           $_SESSION['userid']=$rowsdata[0];
	   $_SESSION['securitylevel']=5;
	   $_SESSION['password']=$npass;
           $_SESSION['username']=$usernametxt;
	   $_SESSION['login']=1;
           $_SESSION['cardtype']=$rowsdata[3];
           $cardtype=$rowsdata[2];

          if($cardtype>1)
	      header("location:profile.php");
           else  header("location:shop.php");
          
            return true;
           }

       }
   }


   $this->updatetrycount($email);
   $this->app->actionerro=1;
   $this->app->actionmsg="Invalide User Email or temp password !";
 
  return false;
 
 }




function updatepass($userid,$npassw){

         $query="update users set password='$npassw' where id= '$userid' and dataconfirm=1 and usertype!=3 limit 1;" ; 
         $loadquery=$this->app->Executequery($query);
       
   }



function generateref($length=10){

    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

  if(!$this->getuserbyref($randomString))
      return $randomString;
   else return $this->generateref();
   
}




}//end of class 

?>
