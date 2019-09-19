<?php
session_start();
if(!$_SESSION["dil"]){
require("dil/en.php");
}
else{
require("dil/".$_SESSION["dil"].".php");
}
if($_SESSION["login"]=='true' && $_SESSION["authority"]==1){ 
include 'header.php';         

include "ayar.php";

function GetStatusName($StatusValue) {
		if($StatusValue=='0')
		{
			if($_SESSION["dil"]=='en')
			$StatusName='Disabled';
		elseif($_SESSION["dil"]=='tr'){
			$StatusName='Pasif';
		}
		
		}elseif($StatusValue=='1')
		{
				if($_SESSION["dil"]=='en')
			$StatusName='Enabled';
		elseif($_SESSION["dil"]=='tr'){
			$StatusName='Aktif';
		}
		}
	return $StatusName;
	}

function GetStatusValue($StatusName) {
		if($StatusName=='Disable')
		{
			$StatusValue='0';
		}elseif($StatusName=='Enable')
		{
			$StatusValue='1';
		}
	return $StatusValue;
	}

function GetPortName($PortID) {
		
		$database_name = "/exec/YIKAMA/PaymentController_Configurations.db";
		$db = new SQLite3($database_name);
        $PortName = $db->querySingle("SELECT Name from PortSettings where ID=='$PortID'");
	return $PortName;
	}

function GetPort($PortName) {
		
		$database_name = "/exec/YIKAMA/PaymentController_Configurations.db";
		$db = new SQLite3($database_name);
        $PortID = $db->querySingle("SELECT ID from PortSettings where Name=='$PortName'");
	return $PortID;
	}

function NozzleCount($Address) {
 
		$database_name = "/exec/YIKAMA/PaymentController_Configurations.db";
		$db = new SQLite3($database_name);
        $count = $db->querySingle("SELECT Count(*) from Nozzle_WashingMachine where MachineID ==$Address AND Nozzle_No>0");
    return $count;
	}
    function hasBarcode($Address) {
 
		$database_name = "/exec/YIKAMA/PaymentController_Configurations.db";
		$db = new SQLite3($database_name);
        $Barcode_Count = $db->querySingle("SELECT Count(*) from BarcodeScanner where MachineNo=$Address");
    return $Barcode_Count;
	}



$ID = $_GET['ID'];

$query = "SELECT * FROM Controller WHERE ID='$ID'";
$result = $db->query($query);
$data = $result->fetchArray();
$query_WashingMachine = "SELECT * FROM WashingMachine";
$result_WashingMachine = $db->query($query_WashingMachine); 
 
?>



	<!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    
                   <div class="container-fluid">

                    <div class="row ">
                        <div class="col-md-12">
                                <!-- DATA TABLE-->
								<div class="card">
                                          <div class="card-header">
                                        <strong><?php echo $dil["washing"];?> </strong><?php echo $dil["machines"];?>
                                               <a href="machine_add.php?ID=<?php echo $ID?>">
                                        <button  class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i><?php echo $dil["washingAddButton"];?>
                                      </button></a>  
                                    </div>
                                    </div>
                                <div class="table-responsive m-b-40">
                                      
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?php echo $dil["tableAddress"];?></th>
                                                <th><?php echo $dil["tablePort"];?></th>
                                                <th><?php echo $dil["tableRepeat"];?></th>
                                                <th><?php echo $dil["tableWakeup"];?></th>
                                                <th><?php echo $dil["tableNozzles"];?></th>
                                                <th><?php echo $dil["tableStatus"];?></th>
                                                <th><?php echo $dil["tableAddNozzle"];?></th>
                                               <th><?php echo $dil["tableBarcode"];?></th>
                                    
                                                <th><?php echo $dil["tableAction"];?></th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php while($row = $result_WashingMachine->fetchArray()) {?>
                                <tr>
                                    <td hidden><?php echo $row['ID'];?></td>
				                    <td><?php echo $row['Address'];?></td>
				                    <td><?php echo GetPort($row['Port']);?></td>
				                    <td><?php echo $row['RepeatCount'];?></td>
				                    <td><?php echo $row['WakeUpCount'];?></td>
				                    <td><?php if (NozzleCount($row['Address'])>0){
                                    ?><a href="nozzle_list.php?Address=<?php echo $row['Address'];?>"><?php echo NozzleCount($row['Address']); ?> <?php echo $dil["tableNozzle"];?> </a><?php }
                                    else{?> <a href="nozzle_add.php?Address=<?php echo $row['Address'];?>"><?php echo $dil["tableAddNozzle"];?></a><?php

                                    }?> </td>
				                    <td><?php echo GetStatusName($row['Status']);?></td>
                                    <td>
                                    <a href="nozzle_add.php?Address=<?php echo $row['Address'];?>"> <div class="table-data-feature">
                                            <button  class="item" data-toggle="" title="<?php echo $dil["tableAddNozzle"];?>" name=""?>
                                              <i class="fa fa-plus-circle" style="color:green;"></i>
                                              </button>
                                          </div></a>
                                    </td>
                                    <td><?php if (hasBarcode($row['Address'])==0){
                                    ?> <a href="barcode_add.php?Address=<?php echo $row['Address'];?>">
                                            <?php echo $dil["insert"];?>
                                         </a><?php }
                                    else{?><a href="barcode_update.php?Address=<?php echo $row['Address'];?>"> 
                                            <?php echo $dil["view"];?>
                                    
                                    </a><?php } ?> 
                                    </td>
                                    <td>
                                        <div class="table-data-feature">
                                     
                                         <a href="./machine_update.php?ID=<?php echo $row['ID']; ?>" > <button id="" name="" class="item" data-toggle="" data-placement="top" title="<?php echo $dil["edit"];?> ">
                                                  <i class="zmdi zmdi-edit" style="color:#0056b3;  "></i>
                                         </button></a>
								         <button onclick="" class="item Delete_Machine" data-toggle="" title="<?php echo $dil["delete"];?> " name="Delete_Machine" id="<?php echo $row['ID']; ?>">
                                              <i class="fa fa-trash" style="color:#ff0000;"></i>
                                              </button>
                                        
                                        </div>
                                     </td>
			                     </tr>
			<?php } ?>
										</tbody>
                                    </table>
                                </div>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                            </div>


                       <script src="./js/ipaddress-validation.js"></script>

                    <script type="text/javascript">


function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

   

            </script>
                    
                    
			
<script type="text/javascript">

    
    $(".Delete_Machine").on("click", function (event) {
        event.preventDefault();
var MachineID=$(this).attr('id');

        $.ajax({
        url: "operation.php?islem=machine_delete",
        type: "POST",
        data :{'MachineID':MachineID},
               success: function (cevap) {
                   
if(cevap!=0)
{
   
    JSalert_With_Redirect_DeleteMachine(cevap);
}
else{

    JSalert_Message("<?php echo $dil["RegisteredNozzle"];?>");
}

           }
			  
    });
});

</script>
                   
			
				
<?php include 'footer.php'; }
else
{ 	echo  $_SESSION["login"];
	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>      
