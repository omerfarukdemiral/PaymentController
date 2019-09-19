<?php
session_start();
if(!$_SESSION["dil"]){
require("dil/en.php");
}
else{
require("dil/".$_SESSION["dil"].".php");
}
if($_SESSION["login"]=='true'){
include 'header.php';

$query = "SELECT ID, * FROM Controller";
    
$count = $db->querySingle("SELECT Count(*) from Controller");
$MachineCount = $db->querySingle("SELECT Count(*) from WashingMachine");
$NozzleCount = $db->querySingle("SELECT Count(*) from Nozzle_WashingMachine WHERE Nozzle_No>0");
$TotalSale = $db->querySingle("SELECT SUM(TotalAmount) from SALES");
$TotalTime = $db->querySingle("SELECT SUM(TotalTime) from SALES");
?>           
	<!-- HEADER DESKTOP-->
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                <?php if( $_SESSION["authority"]==1)
                         {?>  <a href="machine_list.php?ID=1"> <?php
                         }?><div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-car-wash"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?php echo $MachineCount?></h2>
                                                <span><?php echo $dil["menu1"];?></span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                        </div> 
                                    </div> 
									<?php if( $_SESSION["authority"]==1)
                         {?>   </a><?php
                         }?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                <?php if( $_SESSION["authority"]==1)
                         {?>     <a href="machine_list.php?ID=1"><?php
                         }?><div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fa fa-fire-extinguisher"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?php echo $NozzleCount?></h2>
                                                <span><?php echo $dil["tableNozzles"];?></span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                        </div>
                                    </div><?php if( $_SESSION["authority"]==1)
                         {?></a><?php
                         }?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                
                         <a href="sales_list.php">
                        <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                            <i class="fas fa-lira-sign"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?php echo $TotalSale?></h2>
                                                <span><?php echo $dil["totalSaleAmount"];?></span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                        </div>
                                    </div></a>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                            <a href="sales_list.php"> 
                            <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-alarm-check"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?php echo $TotalTime;?></h2>
                                              <p>  <span><?php echo $dil["totalTime"]. " (".$dil["seconds"].")";?></span></p>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                        </div>
                                    </div>
                                     </a>
                                </div>
                            </div>
                           
                        </div>
                        <?php if($count==0)
{ ?>
			<script type="text/javascript">
<!--
window.location = "controller_add.php"
//-->
</script><?php } ?>

<?php include 'footer.php'; }
else
{ 	echo  $_SESSION["login"];
	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>
					     
