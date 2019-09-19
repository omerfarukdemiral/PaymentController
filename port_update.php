<?php session_start();

if($_SESSION["login"]=='true' && $_SESSION["authority"]==1){
include 'header.php';         

$message = ""; 
include "ayar.php";

$ID = $_GET['ID']; 
$query = "Select * from PortSettings Where ID=$ID";
$result = $db->query($query);
$data = $result->fetchArray();

?>

	<!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                  <div class="container-fluid">                
                   <div class="row">
							 <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong> <?php echo $dil["PortUpdateTitle"];?> </strong>
                                    </div>
                                      <form  method="POST" class="form-horizontal" action="" >
                                      
                                    <div class="card-body card-block">
									  <div class="row">
                                       <div class="col-lg-6">
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="" class=" form-control-label">Port No</label>
                                                </div>
												<div class="col col-md-6">
                                                    <input value="<?php echo $data['ID'];?>" type="text"  id="ID" name="ID" placeholder="" class="form-control" disabled>
                                                </div> 
                                                </div> 
												<div class="row form-group">
												<div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["PortName"];?></label>
                                                </div>
												  <div class="col col-md-6">
                                                    <input value="<?php echo $data['Name'];?>" type="text"  id="PortName" name="PortName" placeholder="" class="form-control" disabled>
                                                </div>
                                                </div>
													<div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["Baud"];?></label>
                                                </div>
												
												<div class="col col-md-6">
													<select name="Baud" id="Baud" class="form-control">
                                                        <option <?php if($data['Baud']=="300") echo 'selected="selected"';?> value="300">300</option>
                                                        <option <?php if($data['Baud']=="600") echo 'selected="selected"';?> value="600">600</option>
                                                        <option <?php if($data['Baud']=="1200") echo 'selected="selected"';?> value="1200">1200</option>
                                                        <option <?php if($data['Baud']=="2400") echo 'selected="selected"';?> value="2400">2400</option>
                                                        <option <?php if($data['Baud']=="4800") echo 'selected="selected"';?> value="4800">4800</option>
                                                        <option <?php if($data['Baud']=="9600") echo 'selected="selected"';?> value="9600">9600</option>
                                                        <option <?php if($data['Baud']=="19200") echo 'selected="selected"';?> value="19200">19200</option>
                                                        <option <?php if($data['Baud']=="38400") echo 'selected="selected"';?> value="38400">38400</option>
                                                        <option <?php if($data['Baud']=="57600") echo 'selected="selected"';?>value="57600">57600</option>
                                                        <option <?php if($data['Baud']=="76800") echo 'selected="selected"';?>value="76800">76800</option>
                                                        <option <?php if($data['Baud']=="115200") echo 'selected="selected"';?>value="115200">115200</option>
                                                    </select>                                              
												</div>
												</div>
												</div>
												 <div class="col-lg-6">
                                                <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="" class="form-control-label"><?php echo $dil["Databit"];?></label>
                                                </div>
												    <div class="col col-md-6">
                                                    <input value="<?php echo $data['DataBit'];?>" type="number"  min="0" step="1" id="DataBit" name="DataBit" placeholder="" class="form-control" onkeypress="return isNumberKey(event)">
                                                </div>
                                                </div>
											<div class="row form-group">
												 <div class="col col-md-4">
                                                    <label for="" class="form-control-label"><?php echo $dil["Parity"];?></label>
                                                </div>                                             
											 
                                            
                                                <div class="col col-md-6">
												<select name="Parity" id="Parity" class="form-control">
                                                        <option <?php if($data['Parity']=="NONE") echo 'selected="selected"';?> value="NONE">NONE</option>
                                                        <option <?php if($data['Parity']=="ODD") echo 'selected="selected"';?> value="ODD">ODD</option>
                                                        <option <?php if($data['Parity']=="EVEN") echo 'selected="selected"';?> value="EVEN">EVEN</option>   
                                                    </select> 
                                                </div>
                                            </div>
                                          </div>
                                          </div>
                                          </div>
                                  
                                    <div class="card-footer">
                                        
                                        <button type="submit" name="update_port"  id="update_port" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> <?php echo $dil["updateButton"];?> 
                                        </button>
                                    </div>
                                    </form>
                                </div>                                
                            </div>                     
                        </div>
                        </div>
                    
     <script type="text/javascript">

        $("#update_port").on("click", function (event) {
	      
        event.preventDefault();
        var ID = $('input[name="ID"]').val();
        var Name = $('input[name="PortName"]').val();
		var e = document.getElementById("Baud");
        var Baud = e.options[e.selectedIndex].value;
        var DataBit = $('input[name="DataBit"]').val();
		
		var ee = document.getElementById("Parity");
        var Parity = ee.options[ee.selectedIndex].value;
		
    
        var JSON_Data = "{"+'"'+"ID"+'"'+":"+'"'+ID+'"'+","+'"'+"Name"+'"'+":"+'"'+Name+'"'+","+'"'+"Baud"+'"'+":"+'"'+Baud+'"'+","+'"'+"DataBit"+'"'+":"+'"'+DataBit+'"'+","+'"'+"Parity"+'"'+":"+'"'+Parity+'"'+"}";
            $.ajax({
               url: "operation.php?islem=update_port",
               type: "POST",
               data: "deger="+JSON_Data,
               success: function (cevap) {
                JSalert_With_Redirect_Update("./port_list.php");
				
        
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
       
