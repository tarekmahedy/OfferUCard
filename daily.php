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
				<div class="container">	
				
				
					<!-- SECTION TITLE -->				
					<div class="row">
                 
					<div class="col-sm-12 titlebar">
							
							<br>
							<h3><span>Welcome <?=$sessionuser->fname;?>,   Ref:<b style="color:red; "> <?=strtoupper($sessionuser->ref);?> </b></span></h3>
							<h2>Daily Count</h2>	
							
							<br>
							<br>
						
				 <?php $mydialy=$sessionuser->getdialy(); ?>
                <span style=" color: #fff; ">- Total count clients today : </span> <b style=" color: red; "><?=$mydialy["numb"];?></b><br/>
               
				<div class="intro_buttons">
				<a href="#" class="btn btn--m btn--yellow" style=" padding: 3px;background-color: #CDCDCD; " >
				<span style="font-weight: bold;">Total comision today: </span><b style=" color: red; "><?=$mydialy["value"];?></b>
				</a>
				</div> 
                 



	<br/><br/>
				<span style=" color: #fff; ">- Comision details  : </span>
				<br/><br/>

				<table style="width:100%;color: #fff;">
                <tr>
                <th>Action</th>
                <th>From</th>
                <th>When</th>		
                <th>Amount</th>
                </tr>
      <?php 

         $transferlist=$sessionuser->getcomesionreport();
         $endlooper=count($transferlist);
       
        while($endlooper>0){
         $endlooper--;
         $transferobj=$transferlist[$endlooper];
          ?> 
          <tr <?php if($transferobj["toid"]==$sessionuser->userid){ ?>style=" color:#ABABAB; "<?php } else{ ?>style=" color:#FFF; " <?php } ?>>
                 <td><?php if($transferobj["typ"]==1){?>direct Comision<?php } else if($transferobj["typ"]==2){?>Comision <?php } else if($transferobj["typ"]==5){?>E-Vouchar <?php } ?></td>
                <td><?=$transferobj["fromname"];?> <br/>  REF :<?=$transferobj["fromref"];?></td>			
                <td><?=$transferobj["operationdate"];?></td>
                <td><?=$transferobj["cashvalue"];?></td>
                </tr>
              <? } ?>
             </table> 
							
							
			
							
					</div>

					</div>

					
				</div><!-- End container -->
			</section>	<!-- END FEATURES -->
			
<?php include('footer.php'); ?>
