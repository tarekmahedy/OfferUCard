<?php
   ini_set('session.use_trans_sid', '0');

   include("core/header.php");
   if($sessionuser->getislogin()){
           if($sessionuser->ecardtype>1)
	   header("location:profile.php");
           else  header("location:shop.php");

   }
   else if(!isset($_SESSION['temp']))header("location:login.php");
   
   include('header.php');

?>		
		<section id="features">
				<div class="container">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
					<div class="form-style-10">
<h1>Forget Password !<span></span></h1>
<form  class="cmxform" id="forgetnewform" method="Post" action="fpass.php">
    <div class="section"></div>
    <div class="inner-wrap">
        
       
	   <label>New Password <input type="password"  id="newpassword"  name="password" /></label>
	   <label>Confirm New Password <input type="password" name="confpassword" /></label>
       <input type="hidden" value="ckupdatepass" name="f"/>
    </div>

    <div class="button-section">
     <input class="submit" type="submit" value="Submit" />

    </div>
    
</form>
</div>
		
					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			

		
<?php include('footer.php');?>	
