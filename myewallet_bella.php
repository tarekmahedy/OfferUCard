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
    border: 1px solid #fff;
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
							<h2>MY E-wallet</h2>	
							
							<br>
							<br>
						              <?php 
       $mywallet=$sessionuser->getwallet();
?>
                    <span style=" color: #fff; ">- Direct client comision : </span> <b style=" color: red; "><?=$mywallet["directcommesition"];?></b><br/>
                    <span style=" color: #fff; ">- Client  comision from Direct client : </span> <b style=" color: red; "><?=$mywallet["userscommesition"];?></b><br/>
                    <span style=" color: #fff; ">- Income transfer : </span> <b style=" color: red; "><?=$mywallet["intransfer"];?></b><br/>
                    <span style=" color: #fff; ">- Outer tansfer: </span> <b style=" color: red; "><?=$mywallet["outtransfer"];?> (-)</b><br/>
					<div class="intro_buttons">
				<a href="#" class="btn btn--m btn--yellow" style=" padding: 3px;background-color: #CDCDCD; " >
				<span style="font-weight: bold;">MY Network Balance : </span><b style=" color: red; "><?=$mywallet["total"];?></b>
				</a>
				</div> 
                 
                 <div class="intro_buttons">
				<a href="transfer.php" class="btn btn--m btn--yellow" ><span style="font-weight: bold;">Transfer Amount</span></a>
				</div> 
				<br/><br/>
				<span style=" color: #fff; ">- Transfing details  : </span>
				<br/><br/>

				<table style="width:100%;color: #fff;">
                <tr>
                <th>TO</th>
                <th>From</th>
                <th>When</th>		
                <th>Amount</th>
                </tr>
      <?php 

         $transferlist=$sessionuser->gettransfer();
         $endlooper=count($transferlist);
       
        while($endlooper>0){
         $endlooper--;
         $transferobj=$transferlist[$endlooper];
          ?> 
          <tr <?php if($transferobj["toid"]==$sessionuser->userid){ ?>style=" color:#ABABAB; "<?php } else{ ?>style=" color:#FFF; " <?php } ?>>
                <td><?=$transferobj["toname"];?></td>
                <td><?=$transferobj["fromname"];?></td>		
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
