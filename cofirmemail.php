<?php
 ini_set('session.use_trans_sid', '0');
 include("core/header.php");
 if(!$sessionuser->getislogin())
         header("location:login.php");
 include('header.php');
?>	

		<section id="features">
				<div class="container">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
					<div class="form-style-10">
<h1>Confirmed account!<span></span></h1>
<form  class="cmxform" id="forgetForm" method="Post" action="ourproduc.php">
    <div class="section"></div>
    <div class="inner-wrap">
        
        
	    <label>Thank you for confirmation your account new you can prushase your E-cart  : <br/>
	  
	   
	   </label>
          
    </div>

    <div class="button-section">
     <input class="submit" type="submit" value="Prushase E-cart" />
   
    </div>
    
</form>
</div>
		
					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			

		
<?php include('footer.php');?>	