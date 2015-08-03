<?
$url=$_SERVER['HTTP_REFERER'];                        /////////   Created by Tarek Ibrahim 2009         //////   
$url=explode("&",$url);                               /////////          tareksalwi@yahoo.com           //////
$url=$url[0];            
function uploadfile($file,$param=1){

 define ("FOLDER","../file/");
$type=strtoupper(strrchr($file['name'],'.'));
$types=array();
$types[]=".TXT";
$types[]=".DOC";
$types[]=".RTF";
$types[]=".PDF";
$types[]=".DOCX";
$types[]=".XML";
if(! in_array($type,$types)){
return "1";
}

$imgname=rand(10,100000);
$imagedir=FOLDER."$imgname".$type;
while(file_exists($imagedir)){
$imgname=rand(10,100000);
$imagedir=FOLDER."$imgname".$type;

 }	

    
	
if(!move_uploaded_file($file['tmp_name'],$imagedir)) return "2";
   
	return "$imgname".$type;


}


//////////////////////////////////////////////////////////////////////////////////////////////////////////


function uploadvideo($file,$param=1){

 define ("FOLDER","../video/");
define ("FOLDERSUB","../video/thumb/");
$type=strtoupper(strrchr($file['name'],'.'));
$types=array();
$types[]=".FLV";
$types[]=".WAV";
$types[]=".MP3";
$types[]=".MP4";
if(! in_array($type,$types)){
return "1";
}

$imgname=rand(10,100000);
$imagedir=FOLDER."$imgname".$type;
while(file_exists($imagedir)){
$imgname=rand(10,100000);
$imagedir=FOLDER."$imgname".$type;

 }	

    
	
	 if(!move_uploaded_file($file['tmp_name'],$imagedir)) return "2";
     $imagedirsub=FOLDERSUB."$imgname".$type;
	 careatshot($imagedir,$imagedirsub,$imgname.$type);

   
	return "$imgname".$type;


}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function uploadimg($file,$param=1){

 define ("FOLDER","../photo/");
 define ("FOLDERSUB","../photo/thumb/");

$type=strtoupper(strrchr($file['name'],'.'));
$types=array();
$types[]=".JPG";
$types[]=".GIF";
$types[]=".PNG";
$types[]=".JPGE";
if(! in_array($type,$types)){
return "1";
}

$imgname=rand(10,100000);
$imagedir=FOLDER."$imgname".$type;
while(file_exists($imagedir)){
$imgname=rand(10,100000);
$imagedir=FOLDER."$imgname".$type;

 }	

     $size = getimagesize($file['tmp_name']);
	 $img_attribute= $size[0]."-".$size[1];
	 if(!move_uploaded_file($file['tmp_name'],$imagedir)) return "2";
     $imagedirsub=FOLDERSUB."$imgname".$type;
	 careatthumb($file['tmp_name'],$imagedirsub,$imgname.$type,$size[0],$size[1],100);

   
	return "$imgname".$type;


}



//////////////////////////////////////////////////////////////////////////////////////////////////////////



function careatthumb ($ipath,$tpath,$img_name,$w,$h,$nw)
{

$nh=($h*$nw)/$w;
//The Height Of The Thumbnails
$nh=75;


$thname 	= $tpath;
$img    	= $ipath;
$ext=explode('.',$img_name);

$dimensions = GetImageSize($img);
//$thname = "$tpath/TH".$img_name;

$w=$dimensions[0];
$h=$dimensions[1];

if(strtolower($ext[1])=="jpg")        $img2 = imagecreatefromjpeg($img);
elseif(strtolower($ext[1])=="gif")    $img2 = imagecreatefromgif($img);
elseif(strtolower($ext[1])=="png")    $img2 = imagecreatefrompng($img);
elseif(strtolower($ext[1])=="bmp")    $img2 = imagecreatefromwbmp($img);


$thumb=ImageCreateTrueColor($nw,$nh);
	
$wm = $w/$nw;
$hm = $h/$nh;
	
$h_height = $nh/2;
$w_height = $nw/2;
	

	ImageCopyResampled($thumb,$img2,0,0,0,0,$nw,$nh,$w,$h); 	
	ImageJPEG($thumb,$thname,100); 

imagedestroy($img2);

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function careatshot($imagedir,$imagedirsub){




}

 ///////////////////////////////////////////////////////////////////////////////////////////////////


function delfile($link,$type="1")
{

  if($type=="1")unlink($link);
 else if($type=="2")unlink("../file/".$link);
 else if($type=="3"){
  unlink("../video/".$link);
  unlink("../video/thumb/".$link);
 }
 else if($type=="4"){
  unlink("../photo/".$link);
  unlink("../photo/thumb/".$link);
 }
 
 return true;

}


//////////////////////////////////////////// check mail function  ///////////////////////////////////////////
 
function checkmail($mail){
 

if(!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,4}$", $mail))
        {
		return false;
}

 return true;
 }

 

 ///////////////////////////////////////////////////// send html mail ///////////////////////////////////////////
 
 function dydel($url)
{

  global $app; 
  
  
$table=$_POST['table'];
foreach($_POST['delet'] as $key=> $val){

   $s="delete from $table  where ID='$val' ";
   if(mysql_query($s,$app->Connection)) if($table=="news" || $table=="photos")@delfiles($val,$table);

}
$mes=urlencode("لقد تم الحذف");
header("location:$url id=$_GET[id]&msg=$mes ");
  return false;

}
//////////////////////////////////////////////////////////////

function delfiles($id,$table)
{

  global $app; 
  
  
 $s="select link1 from photos  where ID='$id' ";
 @$datas=mysql_query($s,$app->Connection);
@$data1=mysql_fetch_array($datas);
$link="../photos/".$data1[link1];
        if($link[1]==null) $link="../".$link[0];
else $link=$data1[link1];
unlink($link);

}


////////////////////////////////////////////3- dynamic activate for all types 


function dyactivate(){


  global $app; 
 $table= $_GET['table'];
 $val= $_GET['id'];
  
   $s="update $table  set display=display*-1  where id='$val' ";
   
     if(mysql_query($s,$app->Connection))echo "لقد تم الحفظ !";
	 else echo "لم يتم الحفظ ! ";


}


//////////////////////////////////////////////////////////////////////////////

function dyshow(){


  global $app; 
 $table= $_GET['table'];
 $val= $_GET['id'];
  $show=$_GET['showid'];
   $s=" UPDATE `$table` SET `show` = `show` * '$show' WHERE `ID` = $val LIMIT 1";
     if(mysql_query($s,$app->Connection))echo "لقد تمت العملية";
	 else echo "العملية لم تتم ";


}


//////////////////////////////////////////////////////////////////////////////


function sendmailhtml($to,$subject,$html){
    
   $headers = "MIME-Version: 1.0\n"; 
   $from="webmaster@".$_SERVER['HTTP_HOST'];
   $headers .= "From: $from\r\nReply-To: $from\n";
   $headers .= "Content-type: text/html; charset=utf-8\n"; 
  $message=$message.$html; 
  return  @mail( $to, $subject, $message, $headers ); 


 
 }
 
 
///////////////////////////////////////////////// send mail with attach file and html text ///////////////////////////////// 


 
function sendmailfile($to,$subject,$file,$filename,$filetype,$text){
 

$random_hash = md5(date('r', time())); 
$headers = "MIME-Version: 1.0\n";
$message="";
$data="";
$headers .= "From: webmaster@eldawa.com\r\nReply-To: webmaster@eldawa.com\n";
if (is_uploaded_file($file)) { 

 $filen = fopen($file,'rb'); 
 $data = fread($filen,filesize($file)); 
 fclose($filen);
 $data = chunk_split(base64_encode($data));
}
$mime_boundary = "==Multipart_Boundary_x{$random_hash}x";
$headers .= "Content-Type: multipart/mixed;"." boundary=\"{$mime_boundary}\" \n"; 
$message .="--{$mime_boundary}\n" ."Content-type: text/html; charset=windows-1256 \n";
$message .= $text;
$message .= "\n --{$mime_boundary}\n" . "Content-Type: {$filetype};\n" .  " name=\"{$filename}\"\n" . "Content-Disposition: attachment;\n" . " filename=\"{$filename}\"\n" . "Content-Transfer-Encoding:base64\n\n" . $data . "\n\n"  ."--{$mime_boundary}--\n";
 
$mail_sent = @mail( $to, $subject, $message, $headers ); 
return  $mail_sent ? "??I E? C?C??C? " : "?? ?E? C?C??C?";
 
 
 
 }
 
 



?>