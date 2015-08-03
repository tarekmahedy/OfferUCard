<?php

class user extends dbclass{

	
        public $userid=-1;
	public $fname;
	public $passord;
        public $tel;
        public $email;
        public $ref;
        public $ecardtype;
	public $level;
        public $refto;
        public $parentid;
        public $usertype;
        public $state;
        public $dataconfirm;
        public $regdate;
        public $availablerefusers= array();
        public $geologylist= array();
        public $dialylist= array();
        public $evaouchrslist= array();
        public $walletlist= array();
        public $walletbalance=0;
        public $islogin=false;
	public $activeusers = array();
        public $pandingusers = array();
        var $app;

      public function setapp($appobj){

           $this->app=$appobj;

      }


// typ
//5 evouchar
//2 commetion 
//1 direct commesion 
//3 transfer
//4 purchas 

//action id 6
       function load($useridobj)
        {


        $this->userid=$useridobj;
        $this->app->saveaction($this->userid,$this->userid,6,"loaduser");
        $query="SELECT `fname`, `lname`, `email`, `tel`, `dataconfirm`, `state`, `ref`, `refto`, `reftoid`, `level`, `ecardtype`, `parentid`, `usertype`, `regdate` FROM `users` WHERE `id`='".$this->userid."' limit 1 ;" ; 
         $loadquery=$this->app->Executequery($query);
       if($userdata=mysql_fetch_assoc($loadquery)) {
         
        $this->lname=$userdata["lname"];
	$this->fname=$userdata["fname"];
        $this->tel=$userdata["tel"];
        $this->email=$userdata["email"];
        $this->ref=$userdata["ref"];
        $this->ecardtype=$userdata["ecardtype"];
	$this->level=$userdata["level"];
        $this->refto=$userdata["refto"];
        $this->parentid=$userdata["parentid"];
        $this->usertype=$userdata["usertype"];
        $this->state=$userdata["state"];
        $this->dataconfirm=$userdata["dataconfirm"];
        $this->regdate=$userdata["regdate"];


         } 
  

     }
        

     function getwalletbalance(){

       $this->app->saveaction($this->userid,$this->userid,7,"getwalletbalance");
        $this->walletbalance= 0;
        $query="SELECT sum(cashvalue) as balance,(SELECT sum(cashvalue) FROM `cashtransfer`  WHERE `fromid` ='".$this->userid."' and typ=3 and state=1) as dbit  FROM `cashtransfer`  WHERE `toid` ='".$this->userid."' and typ!=5 and state=1 ;" ; 
        $loadquery=$this->app->Executequery($query);
        if($userdata=mysql_fetch_assoc($loadquery))
        $this->walletbalance= $userdata["balance"]-$userdata["dbit"];
         return  $this->walletbalance;


        }



        function getwallet(){

        $this->app->saveaction($this->userid,$this->userid,8,"getwallet");
        $this->walletlist= array();
        $dirccommet=0; $usercommet=0; $intransfer=0; $outtransfer=0;
        $query="SELECT `id`, `fromid`, `toid`, `typ`, `state`, `cashvalue`, `operationdate` FROM `cashtransfer` WHERE ( (`toid` ='".$this->userid."' or `fromid` ='".$this->userid."' and typ!=1 and typ!=2) or `toid` ='".$this->userid."' ) and typ!=5 and state=1 order by operationdate desc ;" ; 

        $loadquery=$this->app->Executequery($query);
        while($userdata=mysql_fetch_assoc($loadquery)){
        if($userdata["typ"]==1)
         $dirccommet+=$userdata["cashvalue"];
        else if($userdata["typ"]==2)
         $usercommet+=$userdata["cashvalue"];
       else if($userdata["typ"]==3){
       if($userdata["toid"]==$this->userid)
         $intransfer+=$userdata["cashvalue"];
          else 
         $outtransfer+=$userdata["cashvalue"];
          }
        
         }

         $this->walletlist["directcommesition"]=$dirccommet;
         $this->walletlist["userscommesition"]=$usercommet;
         $this->walletlist["intransfer"]=$intransfer;
         $this->walletlist["outtransfer"]=$outtransfer;
         $this->walletlist["total"]=(($dirccommet+$usercommet+$intransfer)-$outtransfer);

         return  $this->walletlist;


        }


  function getredeem(){

        $this->app->saveaction($this->userid,$this->userid,9,"getredeem");
        $redeem= 0;
        $query="SELECT sum((IF(cashvalue = '100', 5,10))) as total FROM `cashtransfer` WHERE `toid` ='".$this->userid."' and (typ=1 or typ=2)and state=1 ;" ; 
        $loadquery=$this->app->Executequery($query);
        if($userdata=mysql_fetch_assoc($loadquery))
         $redeem= $userdata["total"];
         return  $redeem;


        }



  function gettransfer(){

        $this->app->saveaction($this->userid,$this->userid,10,"gettransfer");
        $transferarra= array();
        
        $query="SELECT cas.`id`, cas.`toid`,tov.fname as toname,fro.fname as fromname,tov.ref as toref,fro.ref as fromref, cas.`cashvalue`, cas.`operationdate` FROM `cashtransfer` as cas,`users` as fro,`users` as tov WHERE  (cas.`toid` ='".$this->userid."' or cas.`fromid` ='".$this->userid."') and fro.id=cas.fromid and tov.id=cas.toid and cas.typ=3 and cas.state=1 order by cas.operationdate desc ;" ; 

        $loadquery=$this->app->Executequery($query);
        while($userdata=mysql_fetch_assoc($loadquery))
              $transferarra[]=$userdata;

         return  $transferarra;


        }


 function getcomesionreport(){

        $this->app->saveaction($this->userid,$this->userid,110,"getcomesionreport");
        $transferarra= array();
        $query="SELECT cas.`id`, cas.`toid`,fro.fname as fromname,fro.ref as fromref, cas.`cashvalue`, cas.`operationdate`,cas.typ FROM `cashtransfer` as cas,`users` as fro WHERE cas.`toid` ='".$this->userid."' and fro.id=cas.fromid and cas.state=1 and (cas.typ!=3 and cas.typ!=4) order by cas.operationdate desc ;" ;  
        $loadquery=$this->app->Executequery($query);
        while($userdata=mysql_fetch_assoc($loadquery))
              $transferarra[]=$userdata;

         return  $transferarra;


        }



     function getevaouchr(){

        $this->app->saveaction($this->userid,$this->userid,11,"getevaouchr");
        $this->evaouchrslist= array();
        $query="SELECT count(`id`) as coun, sum(`cashvalue`) as value FROM `cashtransfer` WHERE (`toid` ='".$this->userid."' or `fromid` ='".$this->userid."')  and typ=5 and state=1 order by operationdate desc ;" ; 

        $loadquery=$this->app->Executequery($query);
        while($userdata=mysql_fetch_assoc($loadquery))$this->evaouchrslist= $userdata;

         return  $this->evaouchrslist;

        }


        function getgeology(){

        $this->app->saveaction($this->userid,$this->userid,12,"getgeology");
        $this->geologylist= array();
        $query="SELECT `id`, `ref`, `fname`,`lname`,parentid  FROM `users` as us WHERE `reftoid`='".$this->userid."' limit 6 ;" ; 

        $loadquery=$this->app->Executequery($query);
         while($userdata=mysql_fetch_assoc($loadquery)){

          $useridv=$userdata["id"];
          $userdata["numb"]=$this->getgeologycount($useridv,$this->userid);
          $userdata["value"]=$this->getgeologysum($useridv,$this->userid);
          $this->geologylist[]= $userdata;

          }

          return  $this->geologylist;

        }

 

  function getgeologycount($useridv,$rootid){
   
   $countv=0;
   $query="select id,commesionstate from `users` where state=1 and reftoid='".$useridv."' and `parentid`='".$rootid."' ; ";
   $sqquery=$this->app->Executequery($query);
  while($userdata=mysql_fetch_assoc($sqquery)){
  if($userdata["commesionstate"]==0)
   $countv++;
   $subid=$userdata["id"];
   $countv+=$this->getgeologycount($subid,$rootid);
  }

   return $countv;

}


function getgeologysum($useridv,$rootid){
   
   $sumv=0;
   $query="select id,ecardtype,commesionstate from `users` where state=1 and reftoid='".$useridv."' and `parentid`='".$rootid."' ; ";
   $sqquery=$this->app->Executequery($query);
  while($userdata=mysql_fetch_assoc($sqquery)){
   if($userdata["commesionstate"]==0)
   $sumv+=$userdata["ecardtype"];
   $subid=$userdata["id"];
   $sumv+=$this->getgeologysum($subid,$rootid);
  }

   return $sumv;

}



        function getdialy(){
         $this->app->saveaction($this->userid,$this->userid,13,"getdialy");
        $this->dialylist= array();
        $query="SELECT count(id) as numb,sum(ecardtype) as value  FROM `users`  WHERE  `parentid`='".$this->userid."' and commesionstate='0' ;" ; 
        $loadquery=$this->app->Executequery($query);
        if($userdata=mysql_fetch_assoc($loadquery))$this->dialylist= $userdata;
         return  $this->dialylist;


        }



       function getallrefernce(){
       $this->app->saveaction($this->userid,$this->userid,14,"getallrefernce");
        $this->availablerefusers= array();
        $query="SELECT `id`, `ref`, `fname`,`lname` FROM `users` WHERE `parentid`='".$this->userid."' and level=1 ;" ;
        $loadquery=$this->app->Executequery($query);
        while($userdata=mysql_fetch_assoc($loadquery))$this->availablerefusers[]= $userdata;

         return  $this->availablerefusers;

        }



       function getuserbyreftransfer($refv){

         $query="SELECT `id`, `fname`,`lname` FROM `users` WHERE `ref`='".$refv."'  limit 1;" ; 
         $loadquery=$this->app->Executequery($query);
        if($userdata=mysql_fetch_assoc($loadquery)) return $userdata;
         else return false;


        }



function transfervalue(){

//validate all inputs 
//toidis real user id 
// the amount is less than users balance 
//update to id if not actived yet 
//add commesion to the parent if count ==2 
//or evoucha if count pre commetions =4
//check user level 
//update user leve 

 $userid=$this->app->userid;
 $this->app->saveaction($userid,$userid,15,"transfervalue");
 $cashvalue= $this->app->paremters['amount'];
 $refv= $this->app->paremters['refv'];
 $toidarry= $this->getuserbyreftransfer($refv);
 $toid=$toidarry["id"];
 $userbalance=$this->getwalletbalance();

if($userbalance<$cashvalue || $cashvalue<1 ){
  $this->app->actionerro=1;
  $this->app->actionmsg="Sorry,You Don't have enough credit !";

  return false;
}else if($toidarry==false){
  $this->app->actionerro=1;
  $this->app->actionmsg="Sorry,User Refernce Invalide !";

  return false;

}else {
  $query="INSERT INTO `cashtransfer`(`fromid`, `toid`, `typ`, `state`, `cashvalue`) VALUES ('$userid','$toid',3,1,'$cashvalue')";
  $sqquery=$this->app->Executequery($query);
  if($sqquery) {
   if($this->updateuserstate($toid)){
   $parenttoid=$this->getparentdata($toid);
   if($parenttoid>0)
       $this->assignusers($parenttoid);

    $this->updatealllevel();
    $this->assignpendingusers();
  }

  }

   $this->app->actionerro=2;
   $this->app->actionmsg="Transfer Cash Completed !";

  return true;
  }
  
  return false;
 
}



function getparentdata($userid){

  $query="select count(c.id) as coun,t.reftoid from users as t,users as c  where  c.state=1 and c.parentid=0 and c.assigned=0 and c.reftoid=t.reftoid  and t.id='".$userid."'  ; ";
  $sqquery=$this->app->Executequery($query);
 if($userdata=mysql_fetch_assoc($sqquery)){
  $coun=$userdata["coun"];
  if($coun>1)
    return $userdata["reftoid"];
    else return -1;
  }

  return -1;
 
}


function assignusers($userid){

 $this->app->saveaction($this->userid,$userid,16,"assignusers");
 $looperv=0;
 $equi = array(1,2,1,2,1,2,1,2,2,2,2,1,1,1,1,2,1,1,2,2,2,1,1,2);
 $query="SELECT child.`id`,parent.parentid,parent.lastindex FROM `users` as parent,`users` as child WHERE child.reftoid=parent.id and parent.id='$userid' and child.parentid=0 and child.assigned=0 and child.state=1 limit 2 ;" ; 

 $loadquery=$this->app->Executequery($query);
 $assign=0;
 $verlen=$this->getcountref($userid);

 while($userdata=mysql_fetch_assoc($loadquery)){
  $looperv++;
  $lastindex=$userdata["lastindex"];
  $parentid=$userdata["parentid"];

  if($parentid==0)$assign=1;
   else $assign=0;

  $useridv=$userdata["id"];
  $lastindex=($lastindex+$verlen)%count($equi);
  $indexv=$equi[$lastindex];

 if($indexv==$looperv) $this->updateuserparent($useridv,1,$userid,0,true);
 else $this->updateuserparent($useridv,($lastindex+1),$parentid,$assign);
  

  }


}




function assignpendingusers(){

 $query="select us.id,pr.parentid from users as us ,users as pr where us.`reftoid` =pr.id and pr.`parentid`!=0 and us.`assigned`=1;" ; 
 $loadquery=$this->app->Executequery($query);
 while($userdata=mysql_fetch_assoc($loadquery)){
  $usid=$userdata['id'];
  $parusid=$userdata['parentid'];
  $query1="update users set parentid='$parusid',assigned='0' where  state=1 and id='".$usid."' ; ";
  $sqquery=$this->app->Executequery($query1);

}
 

}




function getcountref($userid){

  $query="select count(id) as cou from users  where  state=1 and parentid='".$userid."' and reftoid='".$userid."' ;";
  $sqquery=$this->app->Executequery($query);

  if($userdata=mysql_fetch_assoc($sqquery))
          return $userdata["cou"];
   
    return 0;


}




function updatealllevel(){

 $this->app->saveaction($this->userid,$this->userid,17,"updatealllevel");
//and us.state=1 
$queryck="select count(us.id) as coun,p.id from users as us,users as p where us.reftoid=p.id and p.level!=2 group by us.reftoid  ; ";
$sqquery=$this->app->Executequery($queryck);
 while($userdata=mysql_fetch_assoc($sqquery)){
 $pa=$userdata["id"];
 $coun=$userdata["coun"];
if($coun>=6){
  $query="update users set level='2'  where  id='$pa' ; ";
  $sqquery=$this->app->Executequery($query);
  if($sqquery) 
    return true;
   else  return false;
 }

}

}



function updateuserparent($userid,$lastindex,$parentid,$assign=0,$ckable=false){

  $query="update users set parentid='$parentid',lastindex='$lastindex',assigned='$assign' where  state=1 and id='".$userid."' ; ";
  $sqquery=$this->app->Executequery($query);
   if($sqquery) return true;
      else  return false;
 

}



function updateuserstate($userid){

  $query="update users set state=1 where (ecardtype!=0 and (ecardtype<=(select sum(cashvalue) from cashtransfer where toid=users.id and typ=3 )) ) and state=0 and id='".$userid."' ; ";
   //  echo $query;
  $sqquery=$this->app->Executequery($query);
  if($sqquery) 
    return true;
   else  return false;
 
}




function systransfervalue($userid,$toid,$cashvalue,$typ,$stat=0){

 //validate all inputs 
  $query="INSERT INTO `cashtransfer`(`fromid`, `toid`, `typ`, `state`, `cashvalue`) VALUES ('$userid','$toid','$typ','$stat','$cashvalue')";
  $sqquery=$this->app->Executequery($query);
  if($sqquery) 
    return true;
   else  return false;
 

}



function getislogin(){
 
$this->islogin=false;
if(isset($_SESSION['userid'])){
$usid=$_SESSION['userid'];
if($usid>0)
    $this->islogin=true;
}else $this->islogin=false;

return $this->islogin;


}


/////////////////////////////////////////////////////////////////////////////////
 
 //action id 3 
function cklogout(){

   $this->app->saveaction($_SESSION['userid'],$_SESSION['userid'],18,"logOut");
   //end session value 
    if(isset($_SESSION['userid']))$_SESSION['userid']=-1;
    if(isset($_SESSION['securitylevel']))$_SESSION['securitylevel']=0;
    if(isset($_SESSION['password']))$_SESSION['password']=-1;
    if(isset($_SESSION['login']))$_SESSION['login']=-1;
    session_destroy();

    return true;
   
}


//action id 19 
function updatecardtype(){

  $this->app->saveaction($this->userid,$this->userid,19,"updatecardtype");
  $ecardtype=$this->app->paremters['carttype'];
  $balanc=$this->getwalletbalance();
if($balanc>=500){
if($ecardtype>0){
  $query="update users set ecardtype='$ecardtype' where  id='".$this->userid."' ; ";
  $sqquery=$this->app->Executequery($query);
  if($sqquery){

  $this->systransfervalue($this->userid,0,500,3,1);
  if($this->updateuserstate($this->userid)){
   $parenttoid=$this->getparentdata($this->userid);
   if($parenttoid>0)
       $this->assignusers($parenttoid);

    $this->updatealllevel();
    $this->assignpendingusers();
  }
   
    header("location:profile.php");

  }
 
}

}else {

  $this->app->actionerro=1;
  $this->app->actionmsg="Sorry,You do not have Credit  !";
   return false;

  }


  $this->app->actionerro=1;
  $this->app->actionmsg="Sorry,The Opeartion Not Complted !";
   return false;
  

}




}//end of class 

?>
