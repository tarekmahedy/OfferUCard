<!DOCTYPE html>
<html lang="en"> 

<head>
	
		<!-- Basic -->
		<meta charset="utf-8">
		<title>Offer.U :: Pay Less . Earn More</title>
		<meta name="author" content="www.badrr.net">
		<meta name="keywords" content="Discount Cards, MLM, Network Marketing">
		<meta name="description" content="Offer.U :: Pay Less . Earn More">		
		<meta property="og:title" content="Offer.U"/>
        <meta property="og:description" content="Offer.U :: Pay Less . Earn More"/>
        <meta property="og:image" content="img/logo.png"/>
		
		<!-- Mobile Specific Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">		
			
		<!-- Libs CSS -->
		<link href="css/bootstrap.css" rel="stylesheet"> 
		<link href="css/font-awesome.min.css" rel="stylesheet">	
		<link href="css/flexslider.css" rel="stylesheet">
		<link href="css/prettyPhoto.css" rel="stylesheet">
		<link href="css/owl.carousel.css" rel="stylesheet">

		<!-- On Scroll Animations -->
		<link href="css/animate.min.css" rel="stylesheet">
		
		<!-- Template CSS -->
		<link href="css/style.css" rel="stylesheet"> 
		<link href="css/btn.css" rel="stylesheet"> 
		<link href="css/screen.css" rel="stylesheet"> 
		

		

		<!-- Responsive CSS -->
		<link href="css/responsive.css" rel="stylesheet"> 
								
		<!-- Favicons -->	
		<link rel="shortcut icon" href="img/icons/favicon.ico">
		<link rel="apple-touch-icon" sizes="144x144" href="img/icons/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="114x114" href="img/icons/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="72x72" href="img/icons/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" href="img/icons/apple-touch-icon.png">
		
		<!-- Popup -->
        <link rel="stylesheet" href="assets/css/styles.html" />
        <link rel="stylesheet" href="assets/framewarp/framewarp.html" />
			
		<!-- Google Fonts -->	
		<link href='css/fontoo.css' rel='stylesheet' type='text/css'>
		<link href='css/fontoo2.css' rel='stylesheet' type='text/css'>
		<link href='css/fontoo3.css' rel='stylesheet' type='text/css'>
		
       
		
			<script src="lib/jquery.js"></script>
			<script src="dist/jquery.validate.js"></script>
			<script src="js/tabcontent.js" type="text/javascript"></script>
            <link href="css/tabcontent.css" rel="stylesheet" type="text/css" />
		
				
	<script>
	$("body").on("click", "#refreshimg", function(){
		$.post("captcha/newsession.php");
		$("#captchaimage").load("captcha/image_req.php");
		return false;
	});
	$.validator.setDefaults({
		submitHandler: function() {
			alert("submitted!");
		}
	});

	$().ready(function() {
		// validate signup form on keyup and submit
		$("#signupForm").validate({
			rules: {
				firstname: {
					required: true,
					minlength: 2
				},
				lastname: {
					required: true,
					minlength: 2
				},
				username: {
					required: true,
					minlength: 10
				},
				pass: {
					required: true,
					minlength: 5
				},
				pass_ew: {
					required: true,
					minlength: 5
				},
				idnumber: {
					required: true,
					minlength: 14,
					maxlength:14,
					number:true
				},
				refv: {
					required: true
				},
				mobilenumber: {
					required: true,
					number:true,
					minlength: 11,
					maxlength:11
				},
				picture: {
					required: true
				},
				nationality: {
					required: true
				},
				captcha: {
				required: true,
				remote: "captcha/process.php"
			    },
				repass: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				},
				repass_ew: {
					required: true,
					minlength: 5,
					equalTo: "#password_ew"
				},
				email: {
					required: true,
					email: true
				},
				topic: {
					required: "#newsletter:checked",
					minlength: 2
				},
				agree: "required"
			},
			messages: {
				firstname:  {
					required: "Please enter your firstname",
					minlength: "Your name must be at least 5 characters long"
				},
				captcha: "Correct captcha is required. Click the captcha to generate a new one",
				lastname: "Please enter your lastname",
				username: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 2 characters"
				},
				idnumber:  {
					required: "Please enter your firstname",
					minlength: "Your ID number must be at 14 characters long",
					maxlength: "Your ID number must be at 14 characters long"
				},
				pass: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				repass: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				email: "Please enter a valid email address",
				agree: "Please accept our policy"
			}
		});
     
		$("#loginForm").validate({
			rules: {
				
				loginemail: {
					required: true
					
				},
				password: {
					required: true,
					minlength: 2
				}
			},
			messages: {
				
				password: {
					required: "Please provide a password"
				},
				
				loginemail: "Please enter a valid email address"
			
			}
		});
		$("#forgetnewform").validate({
			rules: {
				
				password: {
					required: true
					
				},
				confpassword: {
					required: true,
					equalTo: "#newpassword"
					
				}
			},
			
		});
		
	});
	</script>
	
				
	</head>
	
	
	<body>
	
	
	

		<!-- HEADER
		============================================= -->
		<header id="header">		
			<div class="navbar navbar-fixed-top">	
				<div class="container">
				
					
					<!-- Navigation Bar -->
					<div class="navbar-header">
					
						<!-- Responsive Menu Button -->
						<button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-menu">
							<span class="sr-only">Toggle navigation</span> 
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						
						<!-- Logo Image -->
						<a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="logo" role="banner"></a>
						
					</div>	<!-- End Navigation Bar -->
					
					
					<!-- Navigation Menu -->
					<nav id="navigation-menu" class="collapse navbar-collapse" role="navigation">
                        <ul class="nav navbar-nav navbar-right">
		                    <li><a id="GoToHome"  href="index.php">Home</a></li>							
							<?php if(!$sessionuser->getislogin()) { ?>	
							<li><a id="GoToAbout" href="#about">About Us</a></li>
							<li><a id="GoToFeatures" href="#features">Our Concept</a></li>							
							<li><a id="GoToClients" href="ourpartner.php">Our Partners</a></li>	
	                        <li><a href="login.php">Login</a></li>
                           <?php } else { ?>
	                        <li><a  href="shop.php">Shop Now</a></li>	
	                        <li><a  href="mypartners.php">My Partners</a></li>	
	                        <li><a  href="myewallet.php">My E-wallet</a></li>	
	                        <li><a  href="myevoucher.php">My E-voucher</a></li>	
	                        <li><a  href="daily.php">My Daily Counter</a></li>	
	                        <li><a  href="myclients.php">My Clients</a></li>	
	                        <li><a  href="redeem.php">My Redeem</a></li>
                            <li><a id="GoToClients" href="ourpartner.php">Our Partners</a></li> 							
                            <li><a  href="logout.php">LogOut</a></li>				
							<?php } ?>	
						</ul>

					</nav>  <!-- End Navigation Menu -->
					
					
				</div>	 <!-- End container -->
			</div>	  <!-- End navbar fixed top  -->		
		</header>	<!-- END HEADER -->
		
<div id="content_wrapper">		
		
	
		
