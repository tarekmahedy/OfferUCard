<?php
 ini_set('session.use_trans_sid', '0');
 include("core/header.php");


 include('header.php');

?>
		
		
			<!-- INTRO
			============================================= -->
			<section id="intro">
				<div class="overlay">
					<div class="container">	
					
										
						<!-- INTRO SLIDER -->
						<div class="row">													
							<div class="col-md-12 text-center">
															
								<!-- Rotator Content -->
								<div class="intro_slider">											
									<ul class="slides">
																				
										<!-- Intro Slide #1 -->
										<li>
											<div class="intro_slide">
												<h2>Pay Less . Earn More</h2>
												<h3>It's Not Just A Discount Card</h3>
																												
												<!-- INTRO BUTTONS -->
										<?php if(!$sessionuser->getislogin()) {?>		
									  <div class="intro_buttons">
									 <a href="reg.php" class="btn btn--m btn--yellow">Become a Member </a>
									 <a href="login.php" class="btn btn--m btn--yellow">Login</a>

										</div>	
										 <?php } ?>
											</div>
										
										</li>	<!-- End Intro Slide #1 -->	
										
											<!-- Intro Slide #2 -->	
										<li>
											<div class="intro_slide">
												<h2>Pay Less . Earn More</h2>		
												<h3>It's A Revenue Generator</h3>										
																								
														
												<!-- INTRO BUTTONS -->
												<?php if(!$sessionuser->getislogin()) {?>		
									  <div class="intro_buttons">
									 <a href="reg.php" class="btn btn--m btn--yellow">Become a Member </a>
									 <a href="login.php" class="btn btn--m btn--yellow">Login</a>

										</div>	
										 <?php } ?>														
											</div>
										</li>	<!-- End Intro Slide #2 -->	
											
											
										<!-- Intro Slide #3 -->	
										<li>
											<div class="intro_slide">
												<h2>Pay Less . Earn More</h2>
												<h3>Special Offer for the first 1,000 Members</h3>
												<!-- INTRO BUTTONS -->
												<?php if(!$sessionuser->getislogin()) {?>		
									  <div class="intro_buttons">
									 <a href="reg.php" class="btn btn--m btn--yellow">Become a Member </a>
									 <a href="login.php" class="btn btn--m btn--yellow">Login</a>

										</div>	
										 <?php } ?>							
											</div>
										</li>	<!-- End Intro Slide #3 -->															
												
																																																					
											
									</ul>												
								</div>	 <!-- End Rotator Content -->
										
							</div>										
						</div>	 <!-- END INTRO SLIDER -->
							
						
					</div>			<!-- End container -->
				</div>			<!-- End overlay-->
			</section>	<!-- END INTRO -->
			

			<!-- ABOUT
			============================================= -->
			<section id="about">
				<div class="container">	
					<!-- SECTION TITLE -->			
					<div class="row">
						<div class="col-sm-12 titlebar">
							<h3>About Us</h3>
							<h2>Who we are</h2>
							<p>Our firm is a specialized in marketing and retail, throughout years of experience we have provided our customers with the best marketing solutions and services to facilitate more consumer interaction and full integration within loyalty programs to benefit both our retail clients, their customers and provide an enhanced, simple and enjoyable shopping experience.</p>	
						</div>
					</div>
				</div>	  <!-- End container -->
			</section>	<!-- END ABOUT -->	
			
			<!-- FEATURES
			============================================= -->
			<section id="features">
				<div class="container">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
						<div class="col-sm-12 titlebar">
							<h3>Our Concept</h3>
							</br>
							<h2>The Card</h2>	
							<p>OfferU Card holders receive the best value, perks & privileges on wide range of products and services across Egypt. 
							As a valued customer you’re entitled to great discounts and privileges from our rapidly growing network.</p>
							
							<p>By owning the privilege card it will entitle you Instant Discounts every time you use your OfferU Card at participating outlets.
							In addition to that, you’ll always receive special offers, extra discounts, and news about store events and promotions.
							</p>
							</br>
							</br>
							 <img src="img/offeru_card.png" alt="OfferU Elite Card">
							 <img src="img/seperator.png">
							 <img src="img/offeru_card_ex.png" alt="OfferU Express Card">
							</br>
							</br>
							</br>
							
							<h2>The Referral Program</h2>	
							<p>In addition to our card, our program offers a unique commission that generates redeemable cash to our members who refer their family or friends.</p>
						</br>	
<h4>You are just a few steps away from hundreds of discounts on all the things you love to do in Egypt<h4>	

						</div>
					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			
			<!-- CLIENTS
			============================================= -->				
			<section id="clients">
				<div class="container">
						
									
					<!-- SECTION TITLE -->	
					<div class="row">
						<div class="col-sm-12 ">									
							<div class="titlebar">	
								<h2>Our Partners</h2>									
							</div>
						</div>	
					</div>
							
										
					<!-- CLIENTS CAROUSEL HOLDER -->
					<div id="clients-holder" class="row">
						<div class="col-md-12">
						

							<!-- CLIENTS CAROUSEL -->
							<div id="our-customers" class="owl-carousel" >
								<?php $q=mysql_query("select * from partners where state=1 group by name order by id desc");?>					
								<!-- CLIENT LOGO -->
								<?php while($part=mysql_fetch_array($q)){?>
								<div id="client-logo-<?php echo $part['id'];?>" class="item" style="padding: 10px;">
									<img class="img-responsive img-customer" src="haegofferu/admin/app/media/photos/<?php echo $part['image'];?>" style="width: 360px;height: 240px;" alt="<?php echo $part['name'];?>">
								</div>
								<?php } ?>					
								
								
													
						
								
										
							</div>	<!-- END CLIENTS CAROUSEL -->
		
						</div>
					</div>	   <!-- END CLIENTS CAROUSEL HOLDER -->
					
					
					<!-- CLIENTS CAROUSEL NAVIGATION -->	
					<div class="customNavigation">
						<a class="prev btn btn-theme"><i class="fa fa-angle-left"></i></a>
						<a class="next btn btn-theme"><i class="fa fa-angle-right"></i></a>
					</div>
							
							
				</div>	  <!-- End container -->
			</section>	<!-- END CLIENTS -->
			
<?php include('footer.php');  ?>