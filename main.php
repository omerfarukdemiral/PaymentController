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

error_reporting(0);
function setIPAddress()
{
exec("/sbin/reboot");
}

setIPAddress();

function GetStatusName($StatusValue) {
		if($StatusValue=='0')
		{
			$StatusName='Disable';
		}elseif($StatusValue=='1')
		{
			$StatusName='Enable';
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
        $count = $db->querySingle("SELECT Count(*) from Nozzle_WashingMachine where MachineID ==$Address");
    return $count;
	}

function GetInterfaces(){

   


}



function isStaticIP() {

        $dosyaismi="/etc/network/interfaces";
        $okunan=file($dosyaismi);
		$dosya= fopen('/etc/network/interfaces', 'r');	
		$durum=false;
		foreach($okunan as $sira => $satir)
		{
		   if(strstr($satir, "#iface") && strstr($satir, "eth0") && strstr($satir, "inet") && strstr($satir, "dhcp")) {    
					$durum=true;  				  
               }       
        }
    
        
	   fclose($dosya);
	   return $durum;

}

if( isset($_POST['submit_data']) ){

	$ID = isset($_POST['ID']);    
    $Local_IP =$_POST['Local_IP'];
    $App_Port = $_POST['ERP_PortNo'];
    $App_URL = $_POST[''];
    $Controller_Status = $_POST['Status'];
    $MacAddress =$_POST['MacAddress'];
    $Version = $_POST['Version'];
  
    
	// Makes query with post data
	$query = "UPDATE Controller set Local_IP='$Local_IP', MacAddress='$MacAddress',ERP_PortNo='$App_Port'  WHERE ID=$ID";
	
	
	if( $db->exec($query) ){
		$message = $dil["ControllerUpdate"];
	}else{
		$message = $dil["Error"];
	}
}

$ID = $_GET['ID'];
$query = "SELECT * FROM Controller WHERE ID='$ID'";
$result = $db->query($query);
$data = $result->fetchArray();
$mac = $data["MacAddress"];
$MacAddress = implode(":", str_split(str_replace(".", "", $mac), 2));

$query_WashingMachine = "SELECT * FROM WashingMachine";
$result_WashingMachine = $db->query($query_WashingMachine);
//please another address
$dosyaismi="/etc/network/interfaces";
$IP_type=isStaticIP();
$interfaces[0]="";
$interfaces[1]="";
$interfaces[2]="";

if($IP_type==true)
{
        $okunan=file($dosyaismi);
		$dosya= fopen('/etc/network/interfaces', 'r');	
		
		foreach($okunan as $satir)
		{
		 	if(strstr($satir, "address")) {
			 $satir = explode(' ', $satir);
			 $interfaces[0]=$satir[1];
			 }
			if(strstr($satir, "netmask")) {
			 $satir = explode(' ', $satir);
			 $interfaces[1]=$satir[1];
			 }
            
            if(strstr($satir, "gateway")) {
			 $satir = explode(' ', $satir);
			 $interfaces[2]=$satir[1];
			 }      
        }
}


?>



	<!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">      
                            <div class="col-lg-12">
							  <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" name="ControllerForm">
                               
                                  <div class="card">
                                    <div class="card-header">
                                        <strong><?php echo $dil["controller"];?></strong>
                                    </div>
										<div class="card-body card-block">
                                        <div class="row">
											<div class="col-lg-5">
											<div class="row form-group">
													<div class="col col-md-6">
														<label for="Local_IP" class=" form-control-label"><?php echo $dil["mac"];?></label>
													</div>
													<div class="col-12 col-md-6">
														<input disabled type="text" id="macAddress" name="macAddress" placeholder="" class="form-control" value="<?php echo $MacAddress;?>">
													</div>
												</div>
												<div class="row form-group">
												<div class="col col-md-6"> <label for="text-input" class=" form-control-label">IP </label></div>
													 <div class="col col-md-6">
                                                    <div class="form-check-inline form-check">
                                                        <label for="static" class="form-check-label ">
                                                            <input  onclick="getStaticField()" type="radio" id="static" name="inline-radios" value="option1" class="form-check-input" <?php if($IP_type==true) echo 'checked'; ?>>Static
                                                        </label>
                                                        &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;
                                                        <label for="dhcp" class="form-check-label ">
                                                            <input  onclick="getDHCPField()" type="radio" id="dhcp" name="inline-radios" value="option2" class="form-check-input" <?php if($IP_type==false) echo 'checked'; ?>>DHCP
                                                        </label>
                                                      
                                                    </div>
                                                </div>
												</div>
												<div class="row form-group">
													<div class="col col-md-6">
														<label for="Local_IP" class=" form-control-label"><?php echo $dil["IPAddress"];?></label>
													</div>
													<div class="col-12 col-md-6">
														<input type="text" id="Local_IP" name="Local_IP" placeholder="" class="form-control" value="<?php echo trim($interfaces[0]);?>">
													</div>
												</div>
												<div class="row form-group">
													<div class="col col-md-6">
														<label for="Controller_Gateway" class="form-control-label">GateWay </label>
													</div>
													<div class="col-12 col-md-6">
														<input type="text" id="Controller_Gateway" name="Controller_Gateway" placeholder="" class="form-control"  value="<?php echo trim($interfaces[2]);?>">
													</div>
												</div>
                                            
												<div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="Controller_SubnetMask" class=" form-control-label">Subnet Mask</label>
                                                </div>
                                                 <div class="col-12 col-md-6">
                                                    <input type="text" id="Controller_SubnetMask" name="Controller_SubnetMask" placeholder="" class="form-control"  value="<?php echo trim($interfaces[1]); ?>">
                                                </div>
												</div> 
												<div class="row form-group">
													<div class="col col-md-6">
                                                    <label for="Controller_Status" class=" form-control-label"><?php echo $dil["status"];?></label>
													</div>
													<div class="col-12 col-md-6">
                                                    <select name="Controller_Status" id="Controller_Status" class="form-control">
                                                        <option value="1"><?php echo $dil["Enable"];?></option>
                                                        <option value="0"><?php echo $dil["Disable"];?></option>
                                                    </select>
													</div>
												</div> 
											</div>  
											<div class="col-lg-7">
                               
                                  
												<div class="row form-group">
													<div class="col col-md-4">
														<label for="App_Port"  class=" form-control-label"><?php echo $dil["appPort"];?></label>
													</div>
													<div class="col-12 col-md-8">
														<input type="text" id="App_Port" name="App_Port" placeholder="" class="form-control" value="<?php echo $data['ERP_PortNo'];?>" onkeypress="return isNumberKey(event)" onchange="maxValue(this.value)">
													</div>
												</div>
												<div class="row form-group">
													<div class="col col-md-4">
														<label for="App_URL" class=" form-control-label"><?php echo $dil["appURL"];?></label>
													</div>
													<div class="col-12 col-md-8">
														<input type="" id="App_URL" name="App_URL" placeholder="" class="form-control" value="<?php echo $data['ApplicationURL'];?>">
													</div>
												</div>
												<div class="row form-group">
													<div class="col col-md-4">
														<label for="App_URL" class=" form-control-label"><?php echo $dil["appUsername"];?></label>
													</div>
													<div class="col-12 col-md-8">
														<input type="" id="App_username" name="App_username" placeholder="" class="form-control" value="<?php echo $data['ApplicationUserName'];?>">
													</div>
												</div>
												<div class="row form-group">
													<div class="col col-md-4">
														<label for="App_URL" class=" form-control-label"><?php echo $dil["appPassword"];?></label>
													</div>
													<div class="col-12 col-md-8">
														<input type="" id="App_pass" name="App_pass" placeholder="" class="form-control" value="<?php echo $data['ApplicationUserPassword'];?>">
													</div>
												</div>
												<div class="row form-group">
													<div class="col col-md-4">
														<label for="version" class=" form-control-label"><?php echo $dil["version"];?></label>
													</div>
													<div class="col-12 col-md-8">
														<input disabled type="" id="version" name="version" placeholder="" class="form-control" value="<?php echo $data['Version'];?>">
													</div>
												</div>
                                      
											</div>       		
										</div> 		
										</div> 		
										<div class="card-footer">
										<button id="Controller_Update" name="Controller_Update" type="submit" class="btn btn-primary btn-sm" onclick="">
											<i class="fa fa-plus"></i><?php echo $dil["updateButton"];?>
										</button>
										
										</div>
								</div>
                                  
                              </form>
                            </div>
                        </div>
                    </div>
    <script>
		
		
function getStaticField() {
  document.getElementById("Controller_Gateway").disabled = false;
  document.getElementById("Controller_SubnetMask").disabled = false;
  document.getElementById("Local_IP").disabled = false;
}
        
        function getDHCPField() {
  document.getElementById("Controller_Gateway").disabled = true;
  document.getElementById("Controller_SubnetMask").disabled = true;
  document.getElementById("Local_IP").disabled = true;
}
        function maxValue(val){
            if(val>32768)
                {
					JSalert_Warning_Message("Application max value is: 32768 ");
                     document.getElementById("App_Port").value = 32768;

                }
        }
</script>
                    
    <script src="./js/ipaddress-validation.js"></script>
    
    <script type="text/javascript">
if($("input[name='inline-radios']:checked").attr('id')=='static'){
getStaticField();
}
else
{
		getDHCPField();
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

   

            </script>
                                    
                    
<script type="text/javascript">

        $("#Controller_Update").on("click", function (event) {
	       
        event.preventDefault();
       var ID =$('#ID').val();
            if(ID==null)
                {
                    ID=1;
                }		
$stat ="0";
if($("input[name='inline-radios']:checked").attr('id')=='static'){
  if(ValidateIPaddress($('input[name="Local_IP"]').val()) && ValidateIPaddress($('input[name="Controller_Gateway"]').val())&& ValidateIPaddress($('input[name="Controller_SubnetMask"]').val()) )
        {
			
			$stat="1";
		}
}
else{
	 
$stat="1";
}
				
		
				
     if($stat=="1")
	 {
        var Local_IP  = $('input[name="Local_IP"]').val();
        var Controller_Gateway = $('input[name="Controller_Gateway"]').val();
        var Controller_SubnetMask = $('input[name="Controller_SubnetMask"]').val();
        var App_Port = $('input[name="App_Port"]').val();
        var App_URL = $('input[name="App_URL"]').val();
        var App_Username = $('input[name="App_username"]').val();
        var App_Password = $('input[name="App_pass"]').val();
        var IP_type = $("input[name='inline-radios']:checked").attr('id');
	    var e = document.getElementById("Controller_Status");
        var Controller_Status = e.options[e.selectedIndex].value;
        var redirectTime = "1500";
        var JSON_Data = "{"+'"'+"App_Username"+'"'+":"+'"'+App_Username+'"'+","+'"'+"App_Password"+'"'+":"+'"'+App_Password+'"'+","+'"'+"IP_type"+'"'+":"+'"'+IP_type+'"'+","+'"'+"ID"+'"'+":"+'"'+ID+'"'+","+'"'+"Local_IP"+'"'+":"+'"'+Local_IP+'"'+","+'"'+"Controller_Gateway"+'"'+":"+'"'+Controller_Gateway+'"'+","+'"'+"Controller_SubnetMask"+'"'+":"+'"'+Controller_SubnetMask+'"'+","+'"'+"App_Port"+'"'+":"+'"'+App_Port+'"'+","+'"'+"App_URL"+'"'+":"+'"'+App_URL+'"'+","+'"'+"Controller_Status"+'"'+":"+'"'+Controller_Status+'"'+"}";
      
            $.ajax({
               url: "operation.php?islem=controller_update",
               type: "POST",
               data: "deger="+JSON_Data,
               success: function (cevap) {
	       		JSalert_Update();
                 $.ajax({
					url: "reboot.php",
					success: function (cevap) {
					JSalert_Message("Controller reboot edildi. Cihaz yeniden başlatılıyor. Bekleyiniz..");
               }
           });
		  }
		         
        });
	 }
		else{
			JSalert_Warning_Message("Invalid Address Entered. Please Try again");
            }
		
		
		});

</script>
			
				
<?php include 'footer.php'; }
else
{ 	echo  $_SESSION["login"];
	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>         
