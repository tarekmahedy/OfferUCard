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
				<div class="container" style="height: 500px;">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
                 
					<div class="col-sm-12 titlebar">
							
							<br>
							<h3><span>Welcome <?=$sessionuser->fname;?>,   Ref:<b style="color:red; "> <?=strtoupper($sessionuser->ref);?> </b></span></h3>
							<h2>MY E-voucher</h2>	
							
							<br>
							<br>
						
				<?php $evouchers=$sessionuser->getevaouchr(); ?>
                <span style=" color: #fff; ">- Total count E-voucher : </span> <b style=" color: red; "><?=$evouchers["coun"];?></b><br/>
               
				<div class="intro_buttons">
				<a href="#" class="btn btn--m btn--yellow" style=" padding: 3px;background-color: #CDCDCD; " >
				<span style="font-weight: bold;">Total amount E-voucher: </span><b style=" color: red; "><?=$evouchers["value"];?></b>
				</a>
				</div> 
                 
							
					</div>

					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			
<?php include('footer.php'); ?>
