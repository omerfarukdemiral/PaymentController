<?php
session_start();

if($_SESSION["login"]=='true' && $_SESSION["authority"]==1){
	include 'header.php';         

include "ayar.php";

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

function GetInterfacesAddress(){

		$dosyaismi="/etc/network/interfaces";
        $okunan=file($dosyaismi);
        $dosya= fopen($dosyaismi, 'r');
		$Ip_Address="";
		
		foreach($okunan as $sira => $satir)
        {
		 
			
			  if(strstr($satir, "address")) {
			 
			 $satir = explode(' ', $satir);
			 $IP_Address=$satir[1];
			 
            
			 }
			  
		}
		
	   
	   return $IP_Address;
}

//$Local_IP=GetInterfacesAddress();


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
                                        <strong><?php echo $dil["controller"];?></strong> <?php echo $dil["update"];?>
                                       
                                    </div>
										<div class="card-body card-block">
                                        <div class="row">
											<div class="col-lg-5">
												<div class="row form-group">
												<div class="col col-md-4"> <label for="text-input" class=" form-control-label">IP </label></div>
													 <div class="col col-md-8">
                                                    <div class="form-check-inline form-check">
                                                        <label for="static" class="form-check-label ">
                                                            <input  onclick="getStaticField()" type="radio" id="static" name="radios" value="static" class="form-check-input" checked>Static
                                                        </label>
                                                        &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;
                                                        <label for="dhcp" class="form-check-label ">
                                                            <input  onclick="getDHCPField()" type="radio" id="dhcp" name="radios" value="dhcp" class="form-check-input" >DHCP
                                                        </label>
                                                      
                                                    </div>
                                                </div>
												</div>
												<div class="row form-group">
													<div class="col col-md-4">
														<label for="Local_IP" class=" form-control-label"><?php echo $dil["IPAddress"];?></label>
													</div>
													<div class="col-12 col-md-8">
														<input id="Local_IP" name="Local_IP" placeholder="" class="form-control" value="<?php echo $Local_IP; ?>">
													</div>
												</div>
												<div class="row form-group">
													<div class="col col-md-4">
														<label for="Controller_Gateway" class="form-control-label">GateWay </label>
													</div>
													<div class="col-12 col-md-8">
														<input  id="Controller_Gateway" name="Controller_Gateway" placeholder="" class="form-control" value="192.168.0.1">
													</div>
												</div>
                                            
												<div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="Controller_SubnetMask" class=" form-control-label">Subnet Mask</label>
                                                </div>
                                                 <div class="col-12 col-md-8">
                                                    <input  id="Controller_SubnetMask" name="Controller_SubnetMask" placeholder="" class="form-control" value="255.255.252.0">
                                                </div>
												</div> 
                                                <div class="row form-group">
													<div class="col col-md-4">
                                                    <label for="Controller_Status" class=" form-control-label"><?php echo $dil["status"];?></label>
													</div>
													<div class="col-12 col-md-8">
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
														<input type="text" id="App_Port" name="App_Port" placeholder="" class="form-control" onkeypress="return isNumberKey(event)" onchange="maxValue(this.value)" value="8888">
													</div>
												</div>
												<div class="row form-group">
													<div class="col col-md-4">
														<label for="App_URL" class=" form-control-label"><?php echo $dil["appURL"];?></label>
													</div>
													<div class="col-12 col-md-8">
														<input type="" id="App_URL" name="App_URL" placeholder="" class="form-control" value="http://192.168.0.41:8888/Centrowiz/WsIncome">
													</div>
												</div>
                                                <div class="row form-group">
													<div class="col col-md-4">
														<label for="App_URL" class=" form-control-label"><?php echo $dil["appUsername"];?></label>
													</div>
													<div class="col-12 col-md-8">
														<input type="" id="App_username" name="App_username" placeholder="" class="form-control" value="wswmuser">
													</div>
												</div>
                                                <div class="row form-group">
													<div class="col col-md-4">
														<label for="App_URL" class=" form-control-label"><?php echo $dil["appPassword"];?></label>
													</div>
													<div class="col-12 col-md-8">
														<input type="" id="App_pass" name="App_pass" placeholder="" class="form-control" value="User.2019">
													</div>
												</div>
												<div class="row form-group">
													<div class="col col-md-4">
														<label for="version" class=" form-control-label"><?php echo $dil["version"];?></label>
													</div>
													<div class="col-12 col-md-8">
														<input disabled type="" id="version" name="version" placeholder="" class="form-control" value="1.0.0">
													</div>
												</div>
                                     

											</div>       		
										</div> 		
										</div> 		
										<div class="card-footer">
										<button id="Controller_Save" name="Controller_Save" type="submit" class="btn btn-primary btn-sm" onclick="">
											<i class="fa fa-plus"></i> <?php echo $dil["insert"];?>
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
</script>
                    
    <script src="./js/ipaddress-validation.js"></script>
    
    <script type="text/javascript">


function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
        function maxValue(val){
            if(val>32768)
                {
                            alert("Application max value is: 32768 ");
                     document.getElementById("App_Port").value = 32768;

                }
        }

   

            </script>
                                    
                    
<script type="text/javascript">
   
  
       
                      
    
    $("#Controller_Save").on("click", function (event) {
        event.preventDefault();
      
	 
  if($('#static').is(':checked')) { 
             	 
    if(ValidateIPaddress($('input[name="Local_IP"]').val()) && ValidateIPaddress($('input[name="Controller_Gateway"]').val())&& ValidateIPaddress($('input[name="Controller_SubnetMask"]').val()) )
        {
        var ID = 1;
        var IP_type = $("input[name='radios']:checked").attr('id'); 
        var Local_IP = $('input[name="Local_IP"]').val();
        var Controller_Gateway = $('input[name="Controller_Gateway"]').val();
        var Controller_SubnetMask = $('input[name="Controller_SubnetMask"]').val();
        var App_Port = $('input[name="App_Port"]').val();
        var App_URL = $('input[name="App_URL"]').val();
        var App_Username = $('input[name="App_username"]').val();
        var App_Password = $('input[name="App_pass"]').val();
	    var e = document.getElementById("Controller_Status");
        var Controller_Status = e.options[e.selectedIndex].value;

        var JSON_Data = "{"+'"'+"App_Username"+'"'+":"+'"'+App_Username+'"'+","+'"'+"App_Password"+'"'+":"+'"'+App_Password+'"'+","+'"'+"IP_type"+'"'+":"+'"'+IP_type+'"'+","+'"'+"ID"+'"'+":"+'"'+ID+'"'+","+'"'+"Local_IP"+'"'+":"+'"'+Local_IP+'"'+","+'"'+"Controller_Gateway"+'"'+":"+'"'+Controller_Gateway+'"'+","+'"'+"Controller_SubnetMask"+'"'+":"+'"'+Controller_SubnetMask+'"'+","+'"'+"App_Port"+'"'+":"+'"'+App_Port+'"'+","+'"'+"App_URL"+'"'+":"+'"'+App_URL+'"'+","+'"'+"Controller_Status"+'"'+":"+'"'+Controller_Status+'"'+"}";
            $.ajax({
                    url: "operation.php?islem=controller_add",
                    type: "POST",
                    data: "deger="+JSON_Data,
                    success: function (cevap) {
	       		       
						JSalert_Insert(); 		
window.setTimeout(function(){

        // Move to a new location or you can do something else
        window.location.href = "index.php";

    }, 2000);						
						
					
                                
	       		
        
                    }
                 });
        } 
                else{
                      JSalert_Warning_Message("Invalid IP Address Entered. Please Try again");
                    }
      
   }
        else{
            
        var IP_type = $("input[name='radios']:checked").attr('id'); 
        var ID = 1;
        var Local_IP  =document.getElementById('Local_IP').value; 
        var IP_type = $("input[name='radios']:checked").attr('id');    
        var App_Port = $('input[name="App_Port"]').val();
        var App_URL = $('input[name="App_URL"]').val();
	    var e = document.getElementById("Controller_Status");
        var Controller_Status = e.options[e.selectedIndex].value;

        var JSON_Data = "{"+'"'+"Local_IP"+'"'+":"+'"'+Local_IP+'"'+","+'"'+"IP_type"+'"'+":"+'"'+IP_type+'"'+","+'"'+"ID"+'"'+":"+'"'+ID+'"'+","+'"'+"App_Port"+'"'+":"+'"'+App_Port+'"'+","+'"'+"App_URL"+'"'+":"+'"'+App_URL+'"'+","+'"'+"Controller_Status"+'"'+":"+'"'+Controller_Status+'"'+"}";
            $.ajax({
               url: "operation.php?islem=controller_add",
               type: "POST",
               data: "deger="+JSON_Data,
               success: function (cevap) {
	       	
						JSalert_Insert(); 		
window.setTimeout(function(){

        // Move to a new location or you can do something else
        window.location.href = "index.php";

    }, 2000);						
						
					
						
					 
        
               }
           });
        }});

</script>	
                   
<?php include 'footer.php'; 
}
else
{ 	echo  $_SESSION["login"];
	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>
		    
