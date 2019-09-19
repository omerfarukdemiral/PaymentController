<?php
session_start();

if($_SESSION["login"]=='true' && $_SESSION["authority"]==1){
 include 'header.php';         

$message = ""; 
include "ayar.php";

$ID = $_GET['ID']; 

$query = "Select * from WashingMachine Where ID=$ID"; 
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
                                        <strong><?php echo $dil["UpdateMachineTitle"];?> </strong>
                                    </div>
                                      <form  method="POST" class="form-horizontal" action="" >
                                        <div class="card-body card-block">
                                            <div class="row">
                                            <div class="col-lg-4">
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["tableAddress"];?></label>
                                                </div>
                                                <div class="col col-md-8">
                                                    <input value="<?php echo $data['Address'];?>" type="number" id="Address"  min="0" step="1"  name="Address" placeholder="" class="form-control" onkeypress="return isNumberKey(event)" onchange="AddressCheck(this.value)" autocomplete="off" disabled>
                                                </div>
                                                </div>
                                                <div class="row form-group">

                                                <div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["tablePort"];?></label>
                                                </div>
                                                <div class="col col-md-8">
													<select name="Port" id="Port" class="form-control">
                                                        <option <?php if($data['Port']=="ttyAMA0") echo 'selected="selected"'; ?> value="ttyAMA0">1</option>
                                                        <option <?php if($data['Port']=="ttyAMA1") echo 'selected="selected"'; ?>value="ttyAMA1">2</option>
                                                        <option <?php if($data['Port']=="ttyAMA2") echo 'selected="selected"'; ?>value="ttyAMA2">3</option>
                                                        <option <?php if($data['Port']=="ttyAMA3") echo 'selected="selected"'; ?>value="ttyAMA3">4</option>
                                                    </select>                                                   
												</div>
                                                </div>
												  <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["tableRepeat"];?></label>
                                                </div>
												 <div class="col col-md-8">
                                                    <input type="number" min="0" step="1" value="<?php echo $data['RepeatCount'];?>" type="text" id="RepeatCount" name="RepeatCount" placeholder="" class="form-control" onkeypress="return isNumberKey(event)">
                                                </div>
                                         </div>
                                       </div>
										<div class="col-lg-4">
                                            <div class="row form-group">
											 <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["tableWakeup"];?></label>
                                                </div>
											  <div class="col col-md-6">
                                                    <input type="number" min="0" step="1" value="<?php echo $data['WakeUpCount'];?>" type="text" id="WakeUpCount" name="WakeUpCount" placeholder="" class="form-control" onkeypress="return isNumberKey(event)">
                                                </div>
												</div> 
												<div class="row form-group">
												  <div class="col col-md-6">
                                                    <label for="" class="form-control-label"><?php echo $dil["tableStatus"];?></label>
                                                </div>
												<div class="col col-md-6">
													<select name="Status" id="Status" class="form-control">
                                                        <option <?php if($data['Status']=="1") echo 'selected="selected"'; ?> value="1"><?php echo $dil["Enable"];?></option>
                                                        <option <?php if($data['Status']=="0") echo 'selected="selected"'; ?> value="0"><?php echo $dil["Disable"];?></option>
                                                    </select>                                                   
											   </div>  
                                            </div>                    
                                              
                                            </div>
								</div>
								</div>
								 <div class="card-footer">
                                        <input hidden value="<?php echo $data['ID'];?>" id="ID" name="ID">
                                        <button type="submit" name="update_machine" id="update_machine" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> <?php echo $dil["updateButton"];?> 
                                        </button>

                                    </div>
                                    </form>
                                </div>                                
                            </div>                     
                        </div>
                        </div>
                    
                        <script type="text/javascript">

        $("#update_machine").on("click", function (event) {
	       
        event.preventDefault();
        var ID = $('input[name="ID"]').val();
        var e = document.getElementById("Port");
        var Port = e.options[e.selectedIndex].value;
        var ee = document.getElementById("Status");
        var Status = ee.options[ee.selectedIndex].value;
            
        var Address = $('input[name="Address"]').val();
        var WakeUpCount = $('input[name="WakeUpCount"]').val();
        var RepeatCount = $('input[name="RepeatCount"]').val();
        var ProductNo = $('input[name="ProductNo"]').val();
    
        var JSON_Data = "{"+'"'+"ID"+'"'+":"+'"'+ID+'"'+","+'"'+"Address"+'"'+":"+'"'+Address+'"'+","+'"'+"WakeUpCount"+'"'+":"+'"'+WakeUpCount+'"'+","+'"'+"Port"+'"'+":"+'"'+Port+'"'+","+'"'+"Status"+'"'+":"+'"'+Status+'"'+","+'"'+"ProductNo"+'"'+":"+'"'+ProductNo+'"'+","+'"'+"RepeatCount"+'"'+":"+'"'+RepeatCount+'"'+"}";
        $.ajax({
               url: "operation.php?islem=update_machine",
               type: "POST",
               data: "deger="+JSON_Data,
               success: function (cevap) {
				   
				   
                JSalert_With_Redirect_Update("./machine_list.php?ID=1");
	  
				
                   
        
               }
           });
        });
		
		
		
		function AddressCheck(Address)
            {
             $.ajax({
                url: "operation.php?islem=address_check",
                type: "POST",
                data :{'Address':Address},
                success: function (cevap) {
	       			       	if(cevap==1)
                                {
                                   JSalert_Warning_Message("Enter another address.");
                                      
                                    document.getElementById("Address").classList.add("is-invalid");
                                   document.getElementById("Address").focus(); 
                                   document.getElementById("Address").value=""; 
                                 
                            
                                }
                            else{
                                 document.getElementById("Address").classList.remove("is-invalid");
                                    document.getElementById("Address").classList.add("is-valid");
                                   document.getElementById("PortID").focus(); 

                                }
                                
	       		        }        
                    });
            }

</script>
				<?php include 'footer.php'; }
else
{ 	echo  $_SESSION["login"];
	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>     
