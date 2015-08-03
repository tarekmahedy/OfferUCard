<?php
 ini_set('session.use_trans_sid', '0');
 include("core/header.php");

 if($sessionuser->getislogin())
         header("location:profile.php");

 require 'captcha/rand.php';
 $_SESSION['captcha_id'] = $str;
	 
 include('header.php');

?>	
<script>
 $().ready(function() { 	
	$("#forgetForm").validate({
			rules: {
				
				forgetemail: {
					required: true,
					email: true
				}
				
			},
			messages: {
				
				
				forgetemail: "Please enter a valid email address",
				captcha: "Correct captcha is required. Click the captcha to generate a new one"
			
			}
		});
		
	});
	
	</script>
		<section id="features">
				<div class="container">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
					<div class="form-style-10">
<h1>Forget Password !</h1>
<form  class="cmxform" id="forgetForm" method="Post" action="forgetpass.php">
    <div class="section"></div>
    <div class="inner-wrap">
        
           <label>Your email <input type="text" name="forgetemail" /></label>
	  
          
    </div>
	<div class="section">Human ?</div>
        <div class="inner-wrap">
        
		
	<fieldset>
	
		<div id="captchaimage"><a href="<?php echo $_SERVER['PHP_SELF']; ?>" id="refreshimg" title="Click to refresh image"><img src="captcha/images/image.php?<?php echo time(); ?>" width="132" height="46" alt="Captcha image"></a></div>
		<label for="captcha">Enter the characters as seen on the image above (case insensitive):</label>
		<input type="text" maxlength="6" name="captcha" id="captcha">
	</fieldset>

    <div class="button-section">
     <input class="submit" type="submit" value="Submit" />
   
    </div>
   <input type="hidden" value="ckforgetpass" name="f"/> 
</form>
</div>
		
					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			

		
<?php include('footer.php');?>	
