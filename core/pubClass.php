<?php

class pubClass extends dbclass{

      var $app;

      public function setapp($appobj){

           $this->app=$appobj;

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
         $query="SELECT `id`, `fname`, `lname` , `ref`  FROM `users` WHERE `ref`='".$refv."' and state=1 and level=1 limit 1;" ; 
         $loadquery=$this->app->Executequery($query);
         if($userdata=mysql_fetch_assoc($loadquery)){ 
         echo "Name : ".$userdata["fname"]." ".$userdata["lname"]." <br/>REF :".$userdata["ref"];

         } else echo "Not Valide REf";


      }

 function getajaxtransfer(){

         $refv=strtolower($this->app->paremters['refv']);
         //and ecardtype!=0
         $query="SELECT `id`, `fname`, `lname` , `ref` FROM `users` WHERE `ref`='".$refv."' and dataconfirm=1  limit 1;" ; 
         $loadquery=$this->app->Executequery($query);
         if($userdata=mysql_fetch_assoc($loadquery)){ 
         echo "Name : ".$userdata["fname"]." ".$userdata["lname"]." <br/>REF :".$userdata["ref"];

         } else echo "Not Valide REf";


      }


function cklogin(){

 
 $usernametxt = $this->app->paremters['loginemail'];
 $userpassword=$this->app->paremters['password'];
 $this->app->saveaction(0,0,1,"cklogin");
 //try count 
 $query="SELECT `id`, `fname`,ecardtype  FROM `users` WHERE  password='$userpassword' and  (email='$usernametxt' or ref='$usernametxt') and dataconfirm=1;" ; 
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
           else  header("location:../shop.php");
          
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
   
/* if (($_FILES["picture"]["type"] != "image/jpg")
&& ($_FILES["picture"]["type"] != "image/png")
&& ($_FILES["picture"]["type"] != "image/jpeg")) { */

  $this->app->actionmsg="Failed To register Please Check uploaded Id picture only (png,jpg,jpeg) !";
  $this->app->actionerro=1;

  return false;

}


 $idimage = addslashes(file_get_contents($_FILES['picture']['tmp_name'])); 
 $ref=strtolower($this->app->paremters['refv']);
 $refdata=$this->getuserbyrefregister($ref);

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
 $giden=$this->generateref(7);
 $query="INSERT INTO `users`(`fname`, `password`, `lname`, `email`, `tel`,`hometel`,`gender`,`useraddress`,`date_birth`,`idtype`,`idnumber`,`nationality`, `ref`, `refto`, `reftoid`, `usertype`,`idimage`) values('$firstname','$pass','$lastname','$email','$tel','$homenumber','$gender','$address','$birthday','$idtype','$idnumber','$nationality','$giden','$ref','$refid','0','{$idimage}');" ;
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
