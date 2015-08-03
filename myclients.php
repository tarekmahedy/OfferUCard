<?php
 ini_set('session.use_trans_sid', '0');
 include("core/header.php");

 if(!$sessionuser->getislogin())
         header("location:login.php");
// else {

 //if($sessionuser->ecardtype==0)
   // header("location:ourproduct.php");
 //  }

   include('header.php');

?>

<style>
table, th, td {
    border: 1px solid black;
	text-align: center;
}

</style>

		<section id="features">
				<div class="container"  style="height: 1000px;">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
                 
					<div class="col-sm-12 titlebar">
							
							<br>
							<h3><span>Welcome <?=$sessionuser->fname;?>,   Ref:<b style="color:red; "> <?=strtoupper($sessionuser->ref);?> </b></span></h3>
							<h2>My Clients</h2>	
							
							<br>
							<br>
						
						<p style=" color: red; ">List of my clients that need support.</p>
                <div class="intro_buttons">
<?php 
$refusers=$sessionuser->getallrefernce();
$endlooper=count($refusers);
while($endlooper>0){
$endlooper--;
$userref=$refusers[$endlooper];
?>
									 <a href="#" class="btn btn--m btn--yellow" style=" padding: 3px; background-color: #CDCDCD;"><span style="font-weight: bold;"><?=$userref["fname"];?></span> <br/> Ref : <?=$userref["ref"];?></a>
<?php } ?>
	</div>   
                 
							
					</div>

					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			
<?php include('footer.php'); ?>
