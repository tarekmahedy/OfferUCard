<?php
 ini_set('session.use_trans_sid', '0');
 include("core/header.php");
   if($sessionuser->getislogin()){

           if($sessionuser->ecardtype>1)
	   header("location:profile.php");
           else  header("location:shop.php");


   }

   /*else if(isset($_GET["email"])){
        $app->convertosecureparemters($_GET);
        $funcname=$app->execute("ckconfirmmail");
        call_user_func(array($pubfunclass, $funcname));
   }*/

   include('header.php');

?>		
		<section id="features">
				<div class="container">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
					<div class="form-style-10">
<h1>Login !<span></span></h1>
<form  class="cmxform" id="loginForm" method="Post" action="login.php">
    <div class="section"></div>
    <div class="inner-wrap">
        
           <label>E-mail / Reference Code <input type="text" name="loginemail" /></label>
	   <label>Password <input type="password" name="password" /></label>
           <input type="hidden" value="cklogin" name="f"/>
    </div>

    <div class="button-section">
     <input class="submit" type="submit" value="Submit" />
   <span class="privacy-policy">
     <a href="forgetpass.php">Foregt Your Password ?</a> 
     </span>
    </div>
    
</form>
</div>
		
					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			

		
<?php include('footer.php');?>	
