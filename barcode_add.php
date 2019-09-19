<?php
session_start();

if($_SESSION["login"]=='true' && $_SESSION["authority"]==1){
 include 'header.php';         

$message = ""; 
include "ayar.php";

$Address = $_GET['Address']; 
$machine_PortNo='';
$machine_Address='';
$query = "Select * from WashingMachine Where Address=$Address";
$ID;
$result = $db->query($query);
 while($row = $result->fetchArray()) {
       $machine_PortNo = $row['Port'];
       $machine_Address= $row['Address'];
 }
 
 $queryID = "Select ID from Controller";
 $getID = $db->query($queryID);
 while($row = $getID->fetchArray()) {
    $ID= $row['ID'];
}

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
                                        <strong> <?php echo $dil["addBarcode"];?> </strong>
                                    </div>
                                      <form  method="POST" class="form-horizontal" action="" >
                                      
                                    <div class="card-body card-block">
                                       <div class="row">
                                            <div class="col-lg-6">
                                            <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class="form-control-label"><?php echo $dil["tableAddress"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                    <input type="number" id="Address" name="Address" value="<?php echo $Address ?>" class="form-control" >
                                                </div>
                                                </div>
                                                <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class="form-control-label"><?php echo $dil["MachineNo"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                    <input disabled type="number" id="MachineNo" name="MachineNo" value="<?php echo $machine_Address ?>" class="form-control" >
                                                </div>
                                                </div>
												<div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["tablePort"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                <select disabled name="Port" id="Port" class="form-control">
                                                        <option <?php if($machine_PortNo=="ttyAMA0") echo 'selected="selected"'; ?> value="ttyAMA0">1</option>
                                                        <option <?php if($machine_PortNo=="ttyAMA1") echo 'selected="selected"'; ?>value="ttyAMA1">2</option>
                                                        <option <?php if($machine_PortNo=="ttyAMA2") echo 'selected="selected"'; ?>value="ttyAMA2">3</option>
                                                        <option <?php if($machine_PortNo=="ttyAMA3") echo 'selected="selected"'; ?>value="ttyAMA3">4</option>
                                                    </select>                                                     </div>
                                                </div>
                                              

                                                </div> 
												<div class="col-lg-6">
											
												<div class="row form-group">
                                                 <div class="col col-md-6">
                                                    <label for="" class="form-control-label"><?php echo $dil["timeout"];?></label>
                                                </div>
                                               <div class="col col-md-6">
                                                    <input type="number" min="0" step="1" id="timeout" name="timeout" placeholder="" class="form-control" onkeypress="return isNumberKey(event)">
                                                </div>
                                                </div>
                                                <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class="form-control-label"><?php echo $dil["tableStatus"];?></label>
                                                </div>
												 <div class="col col-md-6">
                                                 <select name="Status" id="Status" class="form-control">
                                                        <option value="1"><?php echo $dil["Enable"];?></option>
                                                        <option value="0"><?php echo $dil["Disable"];?></option>
                                                    </select> 
                                                </div>
                                            </div>
                                            </div>
                                            </div>
                                          </div>
                                  
                                    <div class="card-footer">
                                        <button type="submit" name="submit_barcode"  id="submit_barcode" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> <?php echo $dil["insert"];?>  
                                        </button>
                                    </div>
                                    </form>
                                </div>                                
                            </div>                     
                        </div>
                        </div>
                    
     <script type="text/javascript">

        $("#submit_barcode").on("click", function (event) {
	       
        event.preventDefault();
    
        var Address = $('input[name="Address"]').val();
        var MachineNo = $('input[name="MachineNo"]').val();
        var e = document.getElementById("Port");
        var Port = e.options[e.selectedIndex].value;
        var Timeout = $('input[name="timeout"]').val();
        var ee = document.getElementById("Status");
        var Status = ee.options[ee.selectedIndex].value;
	   
            
        var JSON_Data = "{"+'"'+"MachineNo"+'"'+":"+'"'+MachineNo+'"'+","+'"'+"Address"+'"'+":"+'"'+Address+'"'+","+'"'+"Port"+'"'+":"+'"'+Port+'"'+","+'"'+"Timeout"+'"'+":"+'"'+Timeout+'"'+","+'"'+"Status"+'"'+":"+'"'+Status+'"'+"}";
            $.ajax({
               url: "operation.php?islem=barcode_add",
               type: "POST",
               data: "deger="+JSON_Data,
               success: function (cevap) {
				   JSalert_With_Redirect_Insert("./machine_list.php?ID=<?php echo $ID;?>"); 
                  
               }
           });
        });

</script>

				
<?php include 'footer.php'; }
else
{ 	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>         
