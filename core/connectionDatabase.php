<?php

	 
	class app{

	public $isconnected=false;  
        public $seprator=" #%# ";
	public $logfile="logfile.txt";
	public $encoding="utf8";
	public $dbencoding="UTF8";
        public $msg="";
	public $userid="0";
	public $securedlevel=1;
	public $tabper=1;
	public $tabid=0;
	public $lastprim=3;
	public $apptitle="";
        public $poststr="";
	public $ex_state=false;
	public $allowautoserial=false;
	public $userpermessions=array();	
	public $tryfaildmsg="لقد تعديت عدد محاولات تسجيل الدخول برجاء المحاولة لاحقا !";
	public $Usersalt="fun";
	public $Usersessiontempcode=null;
	public $Userrate=0;
	public $UserExLevel=0;
	public $Waitingfunctions = array();
        public $actionmsg="";
	public $actionerro=0;
        public $confirmatilurl="http://www.badrr.net/offeru/login.php?";
        public $resetpassurl="http://www.badrr.net/offeru/fpass.php?";

	var $paremters;
	var $DbHost;
        var $DbName;
        var $DbUser;
        var $DbPass;
	var $Soundex=null;
    var $ConId    = 0;
    var $QueryString = null;
    var $Result   = null;
    var $AffectedRows = 0;
    var $ReturnedRows = 0;
    var $LastInsertId = 0;
    var $Error    = null;
    var $ErrorNum = null;
    var $ErrorMsg = null;
    var $EscapedFieldPrefix = '_';
    var $queries = array();
	var $adminmail="tarekmahedy@gmail.com";
	var $version=100;
	var $dbversion=0;
	var $requestCode=0;
	var $actionname="";
	var $funtime_start;
	var $funtime_end;
	var $funtime_duration;
	var $memoryusage;
	var $clientSocket=null;
	var $baseargustr="http://www.tarekmahedy.com/offeru/index.php?";

	var $argustr="";
	var $argustrmd5="";


///////////////////////////////////////////////////////////////////////////////////////


    function Connect($host, $name, $user='root', $pass='',$reconnect = false)
    {
	    $this->DbHost = $host;
        $this->DbName = $name;
        $this->DbUser = $user;
        $this->DbPass = $pass;
	$this->actionerro=0;
        if($this->ConId && !$reconnect) return true;
        $this->ConId = @mysql_connect($this->DbHost, $this->DbUser, $this->DbPass);
        if(!$this->ConId || !@mysql_select_db($this->DbName, $this->ConId)) return $this->errormail("هناك خطا فى الاتصال بلخادم");
		
		$this->setdbencoding();
        return true;
    }


	function setdbencoding(){
	
	        mysql_query("SET character_set_client=".$this->dbencoding);
			mysql_query("SET character_set_connection=".$this->dbencoding);
			mysql_query("SET character_set_database=".$this->dbencoding);
			mysql_query("SET character_set_results=".$this->dbencoding);
			mysql_query("SET character_set_server=".$this->dbencoding);
			mysql_query("SET NAMES ".$this->dbencoding);
	
	
	}
	
	
    function PConnect($host, $name, $user='root', $pass='',$reconnect = false)
    {
	$this->DbHost = $host;
        $this->DbName = $name;
        $this->DbUser = $user;
        $this->DbPass = $pass;
	$this->actionerro=0;

        if($this->ConId && !$reconnect) return true;
        $this->ConId = @mysql_pconnect($this->DbHost, $this->DbUser, $this->DbPass);
        if(!$this->ConId || !@mysql_select_db($this->DbName, $this->ConId)){
	     $this->errormail("هناك خطا فى الاتصال بلخادم");
		return false;
		
		} 
		else {
		
		   $this->setdbencoding();
           return true;
		}
		
    }

	
	 function Close()
    {
        if($this->ConId)
            return @mysql_close($this->ConId);
        return false;
    }
	
	
	
	function initappsetting(){
	
	//ini_set('session.use_cookies', '0');
	//set_time_limit (30);
	
	
	}
	
	
function appErrorHandler($errno, $errstr, $errfile, $errline)
{
 
  if($errno!=8) {

   $clip=$_SERVER['REMOTE_ADDR'];
   $varva=" client ip : ".$clip." : agent ".$_SERVER['HTTP_USER_AGENT'];
   $desc=" Ern: ".$errno." Erst : ".$errstr." Erln : ".$errline." Erf : ".$errfile;
 
   $inserquery="INSERT INTO `errorlog`(`userid`, `fname`, `desc`, `agent`) VALUES (".$this->userid.",'".$this->actionname."','$desc','$varva')";
   mysql_query($inserquery); 
   
  
  }
   return true;
	
}


function saveaction($userid,$actionownerid,$actiontype,$note="note"){

  $clip=$_SERVER['REMOTE_ADDR'];
  $clagent=$_SERVER['HTTP_USER_AGENT'];

  $query="INSERT INTO `useractions`(`userid`, `actiontype`, `actionownerid`, `ip`, `agent`, `note`) VALUES ('$userid','$actiontype','$actionownerid','$clip','$clagent','$note')";
  $sqquery=$this->Executequery($query);
  
}


function errormail($msgsubject){

       $clip=$_SERVER['REMOTE_ADDR'];
       $varva=$_SERVER['HTTP_USER_AGENT'];
	   $cuurdat= date('Y-m-d');
       $this->writetolog($msgsubject."\n ip:".$clip."\n agent :".$varva);
       $msg=$msgsubject . "\n ip:".$clip."\n agent :".$varva." $cuurdat ";
	   
	   $this->sendmail($this->adminmail,$msgsubject,$msg);
	   
	   return false;
}
	
	
   
	
///////////////////////////////////////////////////
    
function Escape($string)
    {
        if(get_magic_quotes_runtime()) $string = stripslashes($string);
        return @mysql_real_escape_string($string, $this->ConId);
    }
    
/////////////////////////////////////////////////////

  function CheckQuery($query)
    {
        if($query == null || trim($query)==''){
            $this->ErrorMsg = "Can't Use Empty Query String";
            return false;
        } else {
            $type = strtoupper(substr($query, 0, 6));
			if($type == 'INSERT' || $type == 'UPDATE' || $type == 'DELETE' || $type == 'SELECT')
			return true ;
			
			else return false;
			
        }
    }

///////////////////////////////////////////////////////

	
 function Executequery($query)
    {
	
	if($this->CheckQuery($query))
	 return  mysql_query($query,$this->ConId);
	
	
	}
	
	
//write ajason string function 


public function write_jason($arry,$java_callback="null"){
  try{
  
 //can use implode
  
$io=0;
$arr_count=count($arry);
while($io<$arr_count){
$string=$string.$arry[$io].$this->seprator;
$io++;
}
$string=$string.$java_callback;

return $string;


 }catch(Exception $e){
		 
		return ""; 
		 
	 }


}


//end of write ajason function 


function checkinarray($arry,$valu){

$len=count($arry);

$looper=0;
while($looper<$len){
if($arry[$looper]==$valu)return true;

$looper++;
}

return false;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////


function checkpermession($actionname,$scure=0){

$lestr=strlen($actionname);


if($lestr>4 && $lestr<40 ){

$str=substr($actionname,0,3);
$strck=substr($actionname,0,2);
  $this->writetolog($str.":".$this->securedlevel);
  
  if($str=="del" && $this->securedlevel<4)
    return "permessionerrormsg";
	
   else if($str=="upd" && $this->securedlevel<3)
     return "permessionerrormsg";
  else if($str=="add" && $this->securedlevel<2)
    return "permessionerrormsg";
   else if($str=="get" && $this->securedlevel<1)
    return "permessionerrormsg";
   else if($str=="add" || $str=="get" || $str=="del" || $str=="upd" || $strck=="ck") return $actionname;
	  else return "permessionerrormsg";
}
   else return "permessionerrormsg";


}



//////////////////////////////////////////////////


function checkFunctionForUser($actionname,$functionslist){

 if($this->Usersalt!=$this->requestCode){

 $funtemp=$this->requestCode.$actionname.$this->Usersessiontempcode;

 $md5funct=md5($funtemp);
 $lens=count($functionslist);

 while($lens>0){

 $lens--;
 $checkfun=$functionslist[$lens];
 $checkfun=$this->validateFunctionName($checkfun);
 if($checkfun!="permessionerrormsg")
  if(md5($checkfun)==$md5funct){
  
  $this->saveRequestCode();
  return $checkfun;
  }
 }
}
 
 return "permessionerrormsg";
 
}

///////////////////

function validateFunctionName($actionname){

$lestr=strlen($actionname);

if($lestr>4 && $lestr<40 ){

$str=substr($actionname,0,3);
  
  if($str=="del" && $this->securedlevel<4)
    return "permessionerrormsg";
   if($str=="upd" && $this->securedlevel<3)
     return "permessionerrormsg";
  else if($str=="add" && $this->securedlevel<2)
    return "permessionerrormsg";
   else if($str=="get" && $this->securedlevel<1)
    return "permessionerrormsg";
	else if($str=="add" || $str=="get" || $str=="del" || $str="upd") return $actionname;
	 return "permessionerrormsg";
}
   else return "permessionerrormsg";

      return $actionname;

}




//////////////////////////////

 function writesessionlog($actionname){

  $clip=$_SERVER['REMOTE_ADDR'];
  $varva=$_SERVER['HTTP_USER_AGENT'];
 
  $query="INSERT INTO `sessionlog`(`ip`, `agent`,fname) VALUES ('$clip','$varva','$actionname')" ;
  $sqquery=$this->Executequery($query);
  $cellhash=$this->paremters['fl'];
  $cellhash=trim($cellhash);
  $celln=$this->paremters['celln'];
  $celln=trim($celln);
  //update actions table 
 //update users table 
/*
  $query2="UPDATE `reg_users` SET `exper_level`=exper_level+1,lastaction=now() ,hashcell='$cellhash',celln='$celln' where Id =".$this->userid." ;" ;


  $sqquery2=$this->Executequery($query2);
  */
  
}

////////////////////////////////////////////////////

function writeaction($actionname){

$this->getreferedurl();
if(!isset($_GET['ajax']))
header("location:".$this->url."&msg=".$this->msg);
exit();

}




function hashedquery($query){

 $str="";
 while($rowsdata=mysql_fetch_array($sqquery)) {
 
  $coun=mysql_num_fields($sqquery);
  while($coun>0){
  $coun--;
  $productdata[$coun]=$rowsdata[$coun];
  }
   $str=$str. $app->write_jason($productdata," #### ");
   $haveresult=true;
  
 }

 return $str; 
 
}


function convertosecureparemters($arrayget){


$dataparameters= array();
$a=0;
//$value check sql injectiuon 
$this->argustr=$this->baseargustr;
foreach ($arrayget as $key => $value){
            		   $dataparameters[$key]=strip_tags(mysql_real_escape_string($value));
			
      }

$this->userid= isset($dataparameters['identifier']) ? $dataparameters['identifier'] : -1;
$this->requestCode=isset($dataparameters['reqc']) ? $dataparameters['reqc'] : 0;
$this->paremters=$dataparameters;

return $dataparameters;


}




function convertosecureparemtersstring($stringparam){


$arraylevel1=explode("&",$stringparam);
$arrcou=count($arraylevel1);
$dataparameters= array();

while($arrcou>0){
$arrcou--;
$arraylevel2=explode("=",$arraylevel1[$arrcou]);
$dataparameters[$arraylevel2[0]]=strip_tags(mysql_real_escape_string($arraylevel2[1]));

}

$this->userid= isset($dataparameters['identifier']) ? $dataparameters['identifier'] : -1;
$this->requestCode=isset($dataparameters['reqc']) ? $dataparameters['reqc'] : 0;
$this->loadUser();
$this->paremters=$dataparameters;

return $dataparameters;

}



function loadUser(){

$userid=$this->userid;

$query="SELECT  temp_code,identifier,user_rate,exper_level,appversion,dbversion FROM `reg_users` WHERE  Id='$userid' ;" ;
$sqquery=$this->Executequery($query);
 if($sqquery){
 if($rowsdata=mysql_fetch_array($sqquery)){ 
 
  $this->Usersalt=$rowsdata[0];
  $this->Usersessiontempcode=$rowsdata[1];
  $this->Userrate=$rowsdata[2];
  $this->UserExLevel=$rowsdata[3];
  if($rowsdata[4]!=1)
  $this->version=$rowsdata[4];
  
  $this->dbversion=$rowsdata[5];
  
  if($this->version<105)
  $this->getuserappversion($_SERVER['HTTP_USER_AGENT']);
  
  if($this->UserExLevel>5000)
    $this->errormail("user:$userid proactive:".$this->UserExLevel,"writesessionlog");
  
  return ;
 }
 
  } 


}

function getuserappversion($stringagent){

$userid=$this->userid;
$stringagent=strtoupper($stringagent);
$sper=strtoupper("CFNetwork");
$arraylevel1=explode($sper,$stringagent);
$arrcou=count($arraylevel1);
if($arrcou>1){
$vaerar=explode("/",$arraylevel1[0]);
$agentver=$vaerar[1];
$intver=str_replace(".","",$agentver);
$this->version=trim($intver);
}

  $appver=$this->version;
  $query="update  `reg_users` set appversion='$appver' WHERE  Id='$userid' ;" ;
  $sqquery=$this->Executequery($query);
 
   return $this->version;

}



/////////////////////////////////////

function saveRequestCode(){
//appversion
$userid=$this->userid;
$recode=$this->requestCode;
$query="update  `reg_users` set temp_code='$recode' WHERE  Id='$userid' ;" ;
$sqquery=$this->Executequery($query);


}

/////////////////////////////////////

function executewaitingfunction(){


$countfunction=count($this->Waitingfunctions);
$looper=0;

while($countfunction>$looper){

$funcname=$this->Waitingfunctions[$looper]["funname"];
$paramters=$this->Waitingfunctions[$looper]["param"];
call_user_func_array($funcname,$paramters);

$looper++;

}



return true;

}


function setmaxmomeryused(){
return ;
$usedmemory=memory_get_usage();
if($this->memoryusage<$usedmemory)
$this->memoryusage=$usedmemory;


}
/////////////////////////////////////

function execute($functionname){

$this->writetolog("new request: ".$functionname);
$this->funtime_start= microtime(true);
$this->writesessionlog($functionname);
$functionname=$this->checkpermession($functionname);
$this->actionname=$functionname;

return $functionname;


}


function writetolog($txt){

$fp = fopen($this->logfile, "a");
fwrite($fp,$txt."\n");
fclose($fp);


}


//////////////////////////////////////////////////////////////////

function sendSMS($userAccount, $passAccount, $numbers, $sender, $msg,$timeSend=0, $dateSend=0, $deleteKey=0)
{

	//global $arraySendMsg;
	
	$url = "www.mobily.ws/api/msgSend.php";
	$applicationType = "24";  
    $msg = $this->convertToUnicode($msg);
	$sender = urlencode($sender);
	$domainName = $_SERVER['SERVER_NAME'];
	$stringToPost = 
"mobile=".$userAccount."&password=".$passAccount."&numbers=".$numbers."&sender=".$sender."&msg=".$msg."&timeSend=".$timeSend."&dateSend=".$dateSend."&appli
cationType=".$applicationType."&domainName=".$domainName."&deleteKey=".$deleteKey;

	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $stringToPost);
	$result = curl_exec($ch);

	return $result;
	
}

/////////////////////////////////////////////////////////////////

function sendmail($to,$subject,$html){

   $headers = "MIME-Version: 1.0\n"; 
   $from="offeru@offerucard.com";
   $headers .= "From: $from\r\nReply-To: $from\n";
   $headers .= "Content-type: text/html; charset=utf-8\n"; 
   $message=$html; 
  
   return  @mail( $to, $subject, $message, $headers ); 

 
 }
 
	  



 
 function hipchat_notify($room, $message, $from, $color, $type = "text",$token="Ct5XOGVWmIFp5xDapnb2M0RpIWr0ORVjOKIIL45I") {
 
 return false;
    $message=$message." v:".$this->version;
   $fields = array("color" => $color, "notify" => false, "message_format" => $type, "from" => $from, "message" => $message);
   $fields = json_encode($fields);
   $ch = curl_init("https://api.hipchat.com/v2/room/{$room}/notification?auth_token=$token");
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
       'content-type: application/json',
       'content-length: ' . strlen($fields))
   );
   $out = curl_exec($ch);
   $info = curl_getinfo($ch);
   curl_close ($ch);
   if (in_array($info['http_code'], range(200, 206))) {
       return true;
   }
   return false;
   
}
 
 
 

	function intsoundex(){
	
	  $this->Soundex = new I18N_Arabic("Soundex");
	
	}
	
	
	//clean text for fast and best search 
	
	function Cleartext($_text,$lang=1){
	
	$invalidchars = array("%","__","،",".","--");
	$_text=str_replace($invalidchars,"",$_text);
	$findchars=array("ة","ي","أ","إ","آ","ئ","ظ","ق","خ","ج");
    $replacechars = array("ه","ى","ا","ا","ا","ى","ض","غ","ح","ح");
	
	return str_replace($findchars,$replacechars,$_text);
	
	
	}
	
	
	function validatebarcode($barcode){
	
	$countlen=strlen($barcode);
	if($countlen>15 || $countlen<8)return false;
	return true;
	
	}
	
	
	function generatesearchwhere($_arryword,$_coltitle,$_level=1){
	
	$arrcoun=count($_arryword);
	
	if($arrcoun>4)return false;
	
	$matcand=" and ";
	if($_level==2)$matcand=" or ";
	$looper=0;
	$_searchstr="";
	$preword="#####";
	while($looper<$arrcoun){
	
	if($_arryword[$looper]!=$preword)$preword=$_arryword[$looper];
	else return false;
	
	  if($looper>0)
	$_searchstr=$_searchstr.$matcand.$_coltitle." like '%".$_arryword[$looper]."%' ";
	else $_searchstr=$_coltitle." like '%".$_arryword[$looper]."%' ";
	
	$looper++;
	}
	
	return $_searchstr;
	
	}
	
	
	
	function str_soundex($word) {

	
	if($this->Soundex==null)
	  $this->intsoundex();
	  
	if (is_array($word)) {
		$generated = array();
		foreach ($word as $w) {
			$code = $this->str_soundex($w);
			if ($code !== "0000") {
				$generated[] = $code;
			}
		}
		return implode(" ", $generated);
	}
	
	$word = str_replace("َ", "", $word);
	$word = str_replace("ً", "", $word);
	$word = str_replace("ُ", "", $word);
	$word = str_replace("ٌ", "", $word);
	$word = str_replace("ِ", "", $word);
	$word = str_replace("ٍ", "", $word);
	$word = str_replace("ّ", "", $word);
	$word = str_replace("ْ", "", $word);
	$word = str_replace("ـ", "", $word);
	$word = str_replace("ة", "ه", $word);
	$word = str_replace("أ", "ا", $word);
	$word = str_replace("ى ", "ي ", $word);
	$word = str_replace("إ", "ا", $word);
	$word = str_replace("آ", "ا", $word);
	$word = str_replace("ظ", "ض", $word);
	
	return $this->Soundex->soundex($word);
	
}



function to_bool($str) {

	$str_array = explode(" ", $str);
	$new = "";
	foreach ($str_array as $s) {
		$new .= " +" . $s;
	}
	return trim($new);
}




 function create_guid($namespace = '') {     
  
  $guid = '';
    $uid = uniqid("", true);
    $data = $namespace;
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['LOCAL_ADDR'];
    $data .= $_SERVER['LOCAL_PORT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];
	
    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
    $guid = '{' .   
            substr($hash,  0,  8) . 
            '-' .
            substr($hash,  8,  4) .
            '-' .
            substr($hash, 12,  4) .
            '-' .
            substr($hash, 16,  4) .
            '-' .
            substr($hash, 20, 12) .
            '}';
			
    return $guid;
  }

  
  
//دالة تحويل الرساله إلى ترميز UNICODE الخاص بالإرسال من خلال بوابة موبايلي
function convertToUnicode($message)
{
	$chrArray[0] = "،";
	$unicodeArray[0] = "060C";
	$chrArray[1] = "؛";
	$unicodeArray[1] = "061B";
	$chrArray[2] = "؟";
	$unicodeArray[2] = "061F";
	$chrArray[3] = "ء";
	$unicodeArray[3] = "0621";
	$chrArray[4] = "آ";
	$unicodeArray[4] = "0622";
	$chrArray[5] = "أ";
	$unicodeArray[5] = "0623";
	$chrArray[6] = "ؤ";
	$unicodeArray[6] = "0624";
	$chrArray[7] = "إ";
	$unicodeArray[7] = "0625";
	$chrArray[8] = "ئ";
	$unicodeArray[8] = "0626";
	$chrArray[9] = "ا";
	$unicodeArray[9] = "0627";
	$chrArray[10] = "ب";
	$unicodeArray[10] = "0628";
	$chrArray[11] = "ة";
	$unicodeArray[11] = "0629";
	$chrArray[12] = "ت";
	$unicodeArray[12] = "062A";
	$chrArray[13] = "ث";
	$unicodeArray[13] = "062B";
	$chrArray[14] = "ج";
	$unicodeArray[14] = "062C";
	$chrArray[15] = "ح";
	$unicodeArray[15] = "062D";
	$chrArray[16] = "خ";
	$unicodeArray[16] = "062E";
	$chrArray[17] = "د";
	$unicodeArray[17] = "062F";
	$chrArray[18] = "ذ";
	$unicodeArray[18] = "0630";
	$chrArray[19] = "ر";
	$unicodeArray[19] = "0631";
	$chrArray[20] = "ز";
	$unicodeArray[20] = "0632";
	$chrArray[21] = "س";
	$unicodeArray[21] = "0633";
	$chrArray[22] = "ش";
	$unicodeArray[22] = "0634";
	$chrArray[23] = "ص";
	$unicodeArray[23] = "0635";
	$chrArray[24] = "ض";
	$unicodeArray[24] = "0636";
	$chrArray[25] = "ط";
	$unicodeArray[25] = "0637";
	$chrArray[26] = "ظ";
	$unicodeArray[26] = "0638";
	$chrArray[27] = "ع";
	$unicodeArray[27] = "0639";
	$chrArray[28] = "غ";
	$unicodeArray[28] = "063A";
	$chrArray[29] = "ف";
	$unicodeArray[29] = "0641";
	$chrArray[30] = "ق";
	$unicodeArray[30] = "0642";
	$chrArray[31] = "ك";
	$unicodeArray[31] = "0643";
	$chrArray[32] = "ل";
	$unicodeArray[32] = "0644";
	$chrArray[33] = "م";
	$unicodeArray[33] = "0645";
	$chrArray[34] = "ن";
	$unicodeArray[34] = "0646";
	$chrArray[35] = "ه";
	$unicodeArray[35] = "0647";
	$chrArray[36] = "و";
	$unicodeArray[36] = "0648";
	$chrArray[37] = "ى";
	$unicodeArray[37] = "0649";
	$chrArray[38] = "ي";
	$unicodeArray[38] = "064A";
	$chrArray[39] = "ـ";
	$unicodeArray[39] = "0640";
	$chrArray[40] = "ً";
	$unicodeArray[40] = "064B";
	$chrArray[41] = "ٌ";
	$unicodeArray[41] = "064C";
	$chrArray[42] = "ٍ";
	$unicodeArray[42] = "064D";
	$chrArray[43] = "َ";
	$unicodeArray[43] = "064E";
	$chrArray[44] = "ُ";
	$unicodeArray[44] = "064F";
	$chrArray[45] = "ِ";
	$unicodeArray[45] = "0650";
	$chrArray[46] = "ّ";
	$unicodeArray[46] = "0651";
	$chrArray[47] = "ْ";
	$unicodeArray[47] = "0652";
	$chrArray[48] = "!";
	$unicodeArray[48] = "0021";
	$chrArray[49]='"';
	$unicodeArray[49] = "0022";
	$chrArray[50] = "#";
	$unicodeArray[50] = "0023";
	$chrArray[51] = "$";
	$unicodeArray[51] = "0024";
	$chrArray[52] = "%";
	$unicodeArray[52] = "0025";
	$chrArray[53] = "&";
	$unicodeArray[53] = "0026";
	$chrArray[54] = "'";
	$unicodeArray[54] = "0027";
	$chrArray[55] = "(";
	$unicodeArray[55] = "0028";
	$chrArray[56] = ")";
	$unicodeArray[56] = "0029";
	$chrArray[57] = "*";
	$unicodeArray[57] = "002A";
	$chrArray[58] = "+";
	$unicodeArray[58] = "002B";
	$chrArray[59] = ",";
	$unicodeArray[59] = "002C";
	$chrArray[60] = "-";
	$unicodeArray[60] = "002D";
	$chrArray[61] = ".";
	$unicodeArray[61] = "002E";
	$chrArray[62] = "/";
	$unicodeArray[62] = "002F";
	$chrArray[63] = "0";
	$unicodeArray[63] = "0030";
	$chrArray[64] = "1";
	$unicodeArray[64] = "0031";
	$chrArray[65] = "2";
	$unicodeArray[65] = "0032";
	$chrArray[66] = "3";
	$unicodeArray[66] = "0033";
	$chrArray[67] = "4";
	$unicodeArray[67] = "0034";
	$chrArray[68] = "5";
	$unicodeArray[68] = "0035";
	$chrArray[69] = "6";
	$unicodeArray[69] = "0036";
	$chrArray[70] = "7";
	$unicodeArray[70] = "0037";
	$chrArray[71] = "8";
	$unicodeArray[71] = "0038";
	$chrArray[72] = "9";
	$unicodeArray[72] = "0039";
	$chrArray[73] = ":";
	$unicodeArray[73] = "003A";
	$chrArray[74] = ";";
	$unicodeArray[74] = "003B";
	$chrArray[75] = "<";
	$unicodeArray[75] = "003C";
	$chrArray[76] = "=";
	$unicodeArray[76] = "003D";
	$chrArray[77] = ">";
	$unicodeArray[77] = "003E";
	$chrArray[78] = "?";
	$unicodeArray[78] = "003F";
	$chrArray[79] = "@";
	$unicodeArray[79] = "0040";
	$chrArray[80] = "A";
	$unicodeArray[80] = "0041";
	$chrArray[81] = "B";
	$unicodeArray[81] = "0042";
	$chrArray[82] = "C";
	$unicodeArray[82] = "0043";
	$chrArray[83] = "D";
	$unicodeArray[83] = "0044";
	$chrArray[84] = "E";
	$unicodeArray[84] = "0045";
	$chrArray[85] = "F";
	$unicodeArray[85] = "0046";
	$chrArray[86] = "G";
	$unicodeArray[86] = "0047";
	$chrArray[87] = "H";
	$unicodeArray[87] = "0048";
	$chrArray[88] = "I";
	$unicodeArray[88] = "0049";
	$chrArray[89] = "J";
	$unicodeArray[89] = "004A";
	$chrArray[90] = "K";
	$unicodeArray[90] = "004B";
	$chrArray[91] = "L";
	$unicodeArray[91] = "004C";
	$chrArray[92] = "M";
	$unicodeArray[92] = "004D";
	$chrArray[93] = "N";
	$unicodeArray[93] = "004E";
	$chrArray[94] = "O";
	$unicodeArray[94] = "004F";
	$chrArray[95] = "P";
	$unicodeArray[95] = "0050";
	$chrArray[96] = "Q";
	$unicodeArray[96] = "0051";
	$chrArray[97] = "R";
	$unicodeArray[97] = "0052";
	$chrArray[98] = "S";
	$unicodeArray[98] = "0053";
	$chrArray[99] = "T";
	$unicodeArray[99] = "0054";
	$chrArray[100] = "U";
	$unicodeArray[100] = "0055";
	$chrArray[101] = "V";
	$unicodeArray[101] = "0056";
	$chrArray[102] = "W";
	$unicodeArray[102] = "0057";
	$chrArray[103] = "X";
	$unicodeArray[103] = "0058";
	$chrArray[104] = "Y";
	$unicodeArray[104] = "0059";
	$chrArray[105] = "Z";
	$unicodeArray[105] = "005A";
	$chrArray[106] = "[";
	$unicodeArray[106] = "005B";
	$char="\ ";
	$chrArray[107]=trim($char);
	$unicodeArray[107] = "005C";
	$chrArray[108] = "]";
	$unicodeArray[108] = "005D";
	$chrArray[109] = "^";
	$unicodeArray[109] = "005E";
	$chrArray[110] = "_";
	$unicodeArray[110] = "005F";
	$chrArray[111] = "`";
	$unicodeArray[111] = "0060";
	$chrArray[112] = "a";
	$unicodeArray[112] = "0061";
	$chrArray[113] = "b";
	$unicodeArray[113] = "0062";
	$chrArray[114] = "c";
	$unicodeArray[114] = "0063";
	$chrArray[115] = "d";
	$unicodeArray[115] = "0064";
	$chrArray[116] = "e";
	$unicodeArray[116] = "0065";
	$chrArray[117] = "f";
	$unicodeArray[117] = "0066";
	$chrArray[118] = "g";
	$unicodeArray[118] = "0067";
	$chrArray[119] = "h";
	$unicodeArray[119] = "0068";
	$chrArray[120] = "i";
	$unicodeArray[120] = "0069";
	$chrArray[121] = "j";
	$unicodeArray[121] = "006A";
	$chrArray[122] = "k";
	$unicodeArray[122] = "006B";
	$chrArray[123] = "l";
	$unicodeArray[123] = "006C";
	$chrArray[124] = "m";
	$unicodeArray[124] = "006D";
	$chrArray[125] = "n";
	$unicodeArray[125] = "006E";
	$chrArray[126] = "o";
	$unicodeArray[126] = "006F";
	$chrArray[127] = "p";
	$unicodeArray[127] = "0070";
	$chrArray[128] = "q";
	$unicodeArray[128] = "0071";
	$chrArray[129] = "r";
	$unicodeArray[129] = "0072";
	$chrArray[130] = "s";
	$unicodeArray[130] = "0073";
	$chrArray[131] = "t";
	$unicodeArray[131] = "0074";
	$chrArray[132] = "u";
	$unicodeArray[132] = "0075";
	$chrArray[133] = "v";
	$unicodeArray[133] = "0076";
	$chrArray[134] = "w";
	$unicodeArray[134] = "0077";
	$chrArray[135] = "x";
	$unicodeArray[135] = "0078";
	$chrArray[136] = "y";
	$unicodeArray[136] = "0079";
	$chrArray[137] = "z";
	$unicodeArray[137] = "007A";
	$chrArray[138] = "{";
	$unicodeArray[138] = "007B";
	$chrArray[139] = "|";
	$unicodeArray[139] = "007C";
	$chrArray[140] = "}";
	$unicodeArray[140] = "007D";
	$chrArray[141] = "~";
	$unicodeArray[141] = "007E";
	$chrArray[142] = "©";
	$unicodeArray[142] = "00A9";
	$chrArray[143] = "®";
	$unicodeArray[143] = "00AE";
	$chrArray[144] = "÷";
	$unicodeArray[144] = "00F7";
	$chrArray[145] = "×";
	$unicodeArray[145] = "00F7";
	$chrArray[146] = "§";
	$unicodeArray[146] = "00A7";
	$chrArray[147] = " ";
	$unicodeArray[147] = "0020";
	$chrArray[148] = "\n";
	$unicodeArray[148] = "000D";
	$chrArray[149] = "\r";
	$unicodeArray[149] = "000A";

	$strResult = "";
	for($i=0; $i<strlen($message); $i++)
	{
		if(in_array(substr($message,$i,1), $chrArray))
		$strResult.= $unicodeArray[array_search(substr($message,$i,1), $chrArray)];
	}
	return $strResult;
}



}//end of conection class 






 

	
?>
