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


		<section id="features">
				<div class="container" style="height: 500px;">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
                 
					<div class="col-sm-12 titlebar">
							
							<br>
							<h3><span>Welcome <?=$sessionuser->fname;?>,   Ref:<b style="color:red; "> <?=strtoupper($sessionuser->ref);?> </b></span></h3>
							<h2>My Redeem</h2>	
							
							<br>
							<br>
						
				 <?php $redeem=$sessionuser->getredeem(); ?>
               
				<div class="intro_buttons">
				<a href="#" class="btn btn--m btn--yellow" style=" padding: 3px;background-color: #CDCDCD; " >
				<span style="font-weight: bold;">Total amount redeem: </span><b style=" color: red; "><?=$redeem;?></b>
				</a>
				</div> 
                 
							
					</div>

					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			
<?php include('footer.php'); ?>
