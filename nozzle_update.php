<?php	session_start();

if($_SESSION["login"]=='true' && $_SESSION["authority"]==1){
	include 'header.php';         

$message = ""; 
include "ayar.php";

$ID = $_GET['ID']; 

$query = "Select * from Nozzle_WashingMachine Where ID=$ID"; 
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
                                        <strong> <?php echo $dil["UpdateNozzleButton"];?> </strong>
                                    </div>
                                      <form  method="POST" class="form-horizontal" action="" >
                                    <div class="card-body card-block">
                                       <div class="row">
                                            <div class="col-lg-6">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="" class=" form-control-label"><?php echo $dil["NozzleType"];?></label>
                                                </div>
												 <div class="col col-md-6">
                                                    <select name="ProductName" id="ProductName" class="form-control">
                                                        <option <?php if($data['ProductName']=="SU") echo 'selected="selected"'; ?> value="SU" selected="selected">Su</option>
                                                        <option <?php if($data['ProductName']=="KOPUK") echo 'selected="selected"'; ?> value="KOPUK">Köpük</option>
                                                        <option <?php if($data['ProductName']=="CILA") echo 'selected="selected"'; ?> value="CILA">Cila</option>
                                                    </select>
                                                </div>
                                                </div>
												 <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="" class=" form-control-label"><?php echo $dil["NozzleNo"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                    <input disabled value="<?php echo $data['Nozzle_No'];?>" type="number" min="0" step="1" id="NozzleNo" name="NozzleNo" placeholder="" class="form-control" onkeypress="return isNumberKey(event)">
                                                </div>
                                                </div>
                                                 <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="" class=" form-control-label"><?php echo $dil["StockID"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                    <input type="number" min="0" step="1" id="ProductID" name="ProductID" value="<?php echo $data['ProductID'];?>" class="form-control" onkeypress="return isNumberKey(event)">
                                                </div>
                                                </div>
                                                </div>
												  <div class="col-lg-6">
												   <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="" class="form-control-label"><?php echo $dil["tablePrice"];?></label>
                                                </div>
												  <div class="col col-md-6">
                                                    <input type="number" min="0" step="1" value="<?php echo $data['ProductPrice'];?>" type="text" id="ProductPrice" name="ProductPrice" placeholder="" class="form-control" onkeypress="return isNumberKey(event)">
                                                </div>
                                                </div>
												<div class="row form-group">
                                                 <div class="col col-md-3">
                                                    <label for="" class="form-control-label"><?php echo $dil["tableTime"];?></label>
                                                </div>
												 <div class="col col-md-6">
                                                    <input type="number" min="0" step="1" value="<?php echo $data['ProductTime'];?>" type="text" id="ProductTime" name="ProductTime" placeholder="" class="form-control" onkeypress="return isNumberKey(event)" >
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                          </div>
                                    <div class="card-footer">
                                        <input hidden value="<?php echo $data['ID'];?>" id="ID" name="ID">
                                        <input hidden value="<?php echo $data['MachineID'];?>" id="MachineID" name="MachineID">
                                        <button type="submit" name="update_nozzle"  id="update_nozzle" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> <?php echo $dil["updateButton"];?> 
                                        </button>
                                    </div>
                                    </form>
                                </div>                                
                            </div>                     
                        </div>
                        </div>
                    
     <script type="text/javascript">

        $("#update_nozzle").on("click", function (event) {
	       
        event.preventDefault();
        var ID = $('input[name="ID"]').val();
        var e = document.getElementById("ProductName");
        var ProductName = e.options[e.selectedIndex].value;
        var MachineID = $('input[name="MachineID"]').val();
        var Nozzle_No = $('input[name="NozzleNo"]').val();
        var ProductPrice = $('input[name="ProductPrice"]').val();
        var ProductTime = $('input[name="ProductTime"]').val();
        var ProductID = $('input[name="ProductID"]').val();
      
    
        var JSON_Data = "{"+'"'+"ID"+'"'+":"+'"'+ID+'"'+","+'"'+"MachineID"+'"'+":"+'"'+MachineID+'"'+","+'"'+"Nozzle_No"+'"'+":"+'"'+Nozzle_No+'"'+","+'"'+"ProductID"+'"'+":"+'"'+ProductID+'"'+","+'"'+"ProductName"+'"'+":"+'"'+ProductName+'"'+","+'"'+"ProductPrice"+'"'+":"+'"'+ProductPrice+'"'+","+'"'+"ProductTime"+'"'+":"+'"'+ProductTime+'"'+"}";
        $.ajax({
               url: "operation.php?islem=update_nozzle",
               type: "POST",
               data: "deger="+JSON_Data,
               success: function (cevap) {
	       		
				JSalert_With_Redirect_Update("./nozzle_list.php?Address="+MachineID);

        
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
