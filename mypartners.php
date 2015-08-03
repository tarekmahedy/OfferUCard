<?php
 ini_set('session.use_trans_sid', '0');
 include("core/header.php");

 if(!$sessionuser->getislogin())
         header("location:login.php");
  
 
include('header.php');

?>

<style>
table, th, td {
    border: 1px solid black;
	text-align: center;
}

</style>

		<section id="features" style="overflow-x: auto;">
				<div class="container" style="height: 500px;">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
                 
					<div class="col-sm-12 titlebar">
							
							<br>
							<h3><span>Welcome <?=$sessionuser->fname;?>,   Ref:<b style="color:red; "> <?=strtoupper($sessionuser->ref);?> </b></span></h3>
							<h2>MY Partners</h2>	
							
							<br>
							<br>
						<div class="tree">
  <ul>
    <li><a href="#"><?=$sessionuser->fname;?></a>

      <ul>
                <?php 
          $geologyusers=$sessionuser->getgeology();
          $endlooper=count($geologyusers);
          $looper=0;
          while($endlooper>$looper){
           $geologyuser=$geologyusers[$looper];
           if($geologyuser["parentid"]==$sessionuser->userid){
          ?>
     <li><a href="#" style=" background-color: #ffc400;color:#000; "><?=$geologyuser["fname"];?><br/> Ref : <?=$geologyuser["ref"];?></a>
				 <ul>
                 <li><a href="#" >Count :<?=$geologyuser["numb"];?> <br/> Value :<?=$geologyuser["value"];?></a></li>
                </ul></li>
<?php } else {?>
           <li><a href="#" style=" background-color: #D2D2D2;color:#000; "><?=$geologyuser["fname"];?><br/> Ref : <?=$geologyuser["ref"];?></a></li>


       <?php } $looper++; } ?>

                
      </ul>

    </li>
  </ul>
</div>
							
							
							
					</div>

					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			
<?php include('footer.php'); ?>
