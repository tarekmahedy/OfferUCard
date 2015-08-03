<?php

class cron00 extends dbclass{

      var $app;

      public function setapp($appobj){

           $this->app=$appobj;

      }


       function start()
        {

        $query="SELECT us.`id`,us.`state`,us.`reftoid`,us.`ecardtype`,us.`parentid`,pr.commesioncount FROM `users` as us ,`users` as pr WHERE us.`commesionstate`=0 and ((us.`parentid`=pr.id and pr.level=2) or (us.`parentid`=pr.id and us.reftoid=pr.id) );" ; 
        $loadquery=$this->app->Executequery($query);
        if($userdata=mysql_fetch_assoc($loadquery)) {
         
        $id=$userdata["id"];
        $state=$userdata["state"];
        $reftoid=$userdata["reftoid"];
        $ecardtype=$userdata["ecardtype"];
        $parentid=$userdata["parentid"];
        $commestioncount=$userdata["commesioncount"];

        $typ=2;
        if($reftoid==$parentid)$typ=1;
        

       if($commestioncount<4)  $commestioncount++;
        else {
          $commestioncount=0;
          $typ=5;
         }

      
        if($this->updatecommestionstate($id)){ 
		$this->updatecommestioncount($parentid,$commestioncount);
      
		$this->systransfervalue($id,$parentid,$ecardtype,$typ,1);
		$this->start();
		}

     
         } 
  


     }
    


function updatecommestionstate($userid){

  $query="update users set commesionstate='1' where  id='".$userid."' ; ";
  $sqquery=$this->app->Executequery($query);
  if($sqquery) 
    return true;
   else  return false;
 

}

function updatecommestioncount($userid,$count){

  $query="update users set commesioncount='".$count."' where  id='".$userid."' ; ";
  $sqquery=$this->app->Executequery($query);
  if($sqquery) 
    return true;
   else  return false;
 

}

function systransfervalue($userid,$toid,$cashvalue,$typ,$stat=0){

 
  $query="INSERT INTO `cashtransfer`(`fromid`, `toid`, `typ`, `state`, `cashvalue`) VALUES ('$userid','$toid','$typ','$stat','$cashvalue')";
  $sqquery=$this->app->Executequery($query);
  if($sqquery) 
    return true;
   else  return false;
 

}




}//end of class 

?>
