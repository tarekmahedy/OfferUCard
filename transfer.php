<?php
 ini_set('session.use_trans_sid', '0');
 include("core/header.php");
if(!$sessionuser->getislogin())
         header("location:login.php");

//else {
 // $cardtype=$_SESSION['cardtype'];
 // if($cardtype==0)
 //   header("location:ourproduct.php");

    if(isset($app->paremters['refv']))
       $sessionuser->transfervalue();

 //}

 include('header.php');
?>	
   <section id="features">
				<div class="container">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
					<div class="form-style-10">
<h1>Transfer !<span style=" color: red; ">Note : You can't transfer amount more than : <?=$sessionuser->getwalletbalance();?></span></h1>
<form  class="cmxform" id="signupForm" method="post" action="transfer.php">
    <div class="section"></div>
    <div class="inner-wrap">
        
       <label>To Reference <input type="text" name="refv" id="refvtransfer" /></label>
	   <label id="refvalidatediv" style="color:black"> Not Valid Ref </label>
	   <label>Amount <input type="text" name="amount" /></label>
    </div>
    
    <div class="button-section">
     <input class="submit" type="submit" value="Tansfer" />
   
    </div>
</form>
</div>
		
					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			

<?php include('footer.php'); ?>
