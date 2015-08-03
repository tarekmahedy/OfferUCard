<?php
 ini_set('session.use_trans_sid', '0');
 include("core/header.php");
 if(!$sessionuser->getislogin())
         header("location:login.php");

   else if(isset($app->paremters['carttype']))
       $sessionuser->updatecardtype();

 include('header.php');

?>	

		<section id="features">
				<div class="container">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
                     <form  class="cmxform" id="forgetForm" method="Post" action="shop.php">
					<div class="col-sm-12 titlebar">
							
							<br>
							<h3><span>Welcome <?=$sessionuser->fname;?>,   Ref:<b style="color:red; "> <?=strtoupper($sessionuser->ref);?> </b></span></h3>
							<h2>Shop Now</h2>	
							
							<br>
							<br>
						<div class="col-sm-3 titlebar" style="margin-left: auto;margin-right: auto;float: initial;">
							 <img src="img/offeru_card.png" style="width: 80%" alt="OfferU Elite Card">
							 <img src="img/seperator.png">
							 <h4>Elite E-card (500)</h4>
							 <br>
							 <input type="hidden" name="carttype" value="250" />
							 <div class="intro_buttons">
					             <?php if($sessionuser->ecardtype<=0) {?>
                                                     <input class="btn btn--m btn--yellow" type="submit" value="Shop" />
							 
                                                         <? } ?>
							</div>
						</div>
							
							
							
					</div>
</form>
					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			

		
<?php include('footer.php');?>	
