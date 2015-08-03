<?php
 include("core/header.php");
 include("core/cron00.php");
 date_default_timezone_set('Africa/Cairo');

if (date('H') == 00) {
 $cronobj=new cron00(); 
 $cronobj->setapp($app);
 $cronobj->start();
 echo "Done ";

}else echo date('H')." time is ";


