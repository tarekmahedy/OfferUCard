<!-- FOOTER
			============================================= -->
			
			<footer id="footer">
				<div class="container">
				
				
				
				
					<!-- FOOTER COPYRIGHT -->
					<div class="row">						
						<div id="footer_copyright" class="col-sm-12 text-center">		
							<p>Copyright 2015 <span><a href="index.php">OfferU Card</a></span>. All Rights Reserved. Developed By <span><a href="http://badrr.net/" >BADR</a></span> </p>	
						</div>
					</div>
					
					
					<!-- FOOTER SOCIALS -->
					<div class="row">
					<div id="footer_socials" class="col-sm-12 text-center">	
					<div id="contact_icons">																	
								<ul class="contact-socials clearfix">
									<!--<li><a class="foo_social ico-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a class="foo_social ico-twitter" href="#"><i class="fa fa-twitter"></i></a></li>	
									<li><a class="foo_social ico-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
																									
								
									<li><a class="foo_social ico-dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>									
									<li><a class="foo_social ico-pinterest" href="#"><i class="fa fa-pinterest"></i></a></li>		
									<li><a class="foo_social ico-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
									<li><a class="foo_social ico-digg" href="#"><i class="fa fa-digg"></i></a></li>
									<li><a class="foo_social ico-deviantart" href="#"><i class="fa fa-deviantart"></i></a></li>
									<li><a class="foo_social ico-envelope" href="#"><i class="fa fa-envelope-square"></i></a></li>							
									<li><a class="foo_social ico-delicious" href="#"><i class="fa fa-delicious"></i></a></li>
									<li><a class="foo_social ico-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
									<li><a class="foo_social ico-dropbox" href="#"><i class="fa fa-dropbox"></i></a></li>
									<li><a class="foo_social ico-skype" href="#"><i class="fa fa-skype"></i></a></li>									
									<li><a class="foo_social ico-youtube" href="#"><i class="fa fa-youtube"></i></a></li>
									<li><a class="foo_social ico-tumblr" href="#"><i class="fa fa-tumblr"></i></a></li>
									<li><a class="foo_social ico-vimeo" href="#"><i class="fa fa-vimeo-square"></i></a></li>
									<li><a class="foo_social ico-flickr" href="#"><i class="fa fa-flickr"></i></a></li>
									<li><a class="foo_social ico-github" href="#"><i class="fa fa-github-alt"></i></a></li>
									<li><a class="foo_social ico-renren" href="#"><i class="fa fa-renren"></i></a></li>
									<li><a class="foo_social ico-vk" href="#"><i class="fa fa-vk"></i></a></li>
									<li><a class="foo_social ico-xing" href="#"><i class="fa fa-xing"></i></a></li>
									<li><a class="foo_social ico-weibo" href="#"><i class="fa fa-weibo"></i></a></li>
									<li><a class="foo_social ico-rss" href="#"><i class="fa fa-rss"></i></a></li>										
								-->									

								</ul>
							</div>

						</div>	
						
					</div>	<!-- END FOOTER SOCIALS -->

						
				</div>	  <!-- End container -->							
			</footer>	<!-- END FOOTER -->	
		
		</div>	<!-- END CONTENT WRAPPER -->
	
	
	
		<!-- EXTERNAL SCRIPTS
		============================================= -->		
		<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>
		<script src="js/bootstrap.min.js" type="text/javascript"></script>	
		<script src="js/modernizr.custom.js" type="text/javascript"></script>
		<script src="js/jquery.easing.js" type="text/javascript"></script>
		<script src="js/retina.js" type="text/javascript"></script>	
		<script src="js/jquery.stellar.min.js" type="text/javascript"></script>	
		<script defer src="js/jquery.flexslider.js" type="text/javascript"></script>
		<script src="js/jquery.parallax-1.1.3.js" type="text/javascript"></script>
		<script defer src="js/count-to.js"></script>
		<script defer src="js/jquery.appear.js"></script>
		<script src="js/jquery.mixitup.js" type="text/javascript"></script>
		<script src="js/jquery.prettyPhoto.js" type="text/javascript"></script>
		<script src="js/owl.carousel.js" type="text/javascript"></script>
		<script src="js/jquery.easypiechart.min.js"></script>
		<script defer src="js/jquery.validate.min.js" type="text/javascript"></script>	
		<script src="js/waypoints.min.js" type="text/javascript"></script>	
		<script src="js/custom.js" type="text/javascript"></script>	
		
		
<script src="js/jquery.growl.js" type="text/javascript"></script>
<link href="css/jquery.growl.css" rel="stylesheet" type="text/css" />			
<script type="text/javascript">
   <?php if($app->actionerro>0){ 
if($app->actionerro==1) { ?>
  $.growl.error({ message: "<?=$app->actionmsg;?>" });
<?php } else if($app->actionerro==2){ ?>
  $.growl.notice({ message: "<?=$app->actionmsg;?>" });
<?php } else if($app->actionerro==3) { ?>
  $.growl.warning({ message: "<?=$app->actionmsg;?>" });
 //$.growl({ title: "Error", message: "<?=$app->actionmsg;?>" });
  <?php } } ?>
</script>
			

		
		
		<script type="text/javascript">


$("#refv" ).keyup(function() {
if(this.value.length==7){
var refv=this.value;
    $("#refvalidatediv") .html( "Loading .... " );
    $.post("core/header.php", {"f": "getajax","refv": refv}, function(result){
        $("#refvalidatediv").html(result);
    });

}
else
  $("#refvalidatediv") .html( "Not Valid Ref " );

});

$("#refvtransfer" ).keyup(function() {
if(this.value.length==7){
var refv=this.value;
    $("#refvalidatediv") .html( "Loading .... " );
    $.post("core/header.php", {"f": "getajaxtransfer","refv": refv}, function(result){
        $("#refvalidatediv").html(result);
    });

}
else
  $("#refvalidatediv") .html( "Not Valid Ref " );

});


</script> 
	

	
	</body>
	    

</html>
