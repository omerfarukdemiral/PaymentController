<?php
session_start();

if($_SESSION["login"]=='true' && $_SESSION["authority"]==1){
 include 'header.php';         

$message = ""; 
include "ayar.php";

$Address = $_GET['Address']; 
$nozzleNumber='';
$query = "Select Max(Nozzle_No) from Nozzle_WashingMachine Where MachineID=$Address"; 
$result = $db->query($query);
 while($row = $result->fetchArray()) {
       $nozzleNumber = $row['Max(Nozzle_No)']+1;
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
                                        <strong> <?php echo $dil["AddNozzleButton"];?> </strong>
                                    </div>
                                      <form  method="POST" class="form-horizontal" action="" >
                                      
                                    <div class="card-body card-block">
                                       <div class="row">
                                            <div class="col-lg-6">
                                            <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <input hidden type="text" id="Address" name="Address" value="<?php echo $Address; ?>">
                                                    <label for="" class=" form-control-label"> <?php echo $nozzleNumber;?>.  <?php echo $dil["tableNozzle"];?> </label>
                                                </div>
												 <div class="col col-md-6">
                                                    <select name="type" id="type" class="form-control">
                                                        <option value="SU" selected="selected">Su</option>
                                                        <option value="KOPUK">Köpük</option>
                                                        <option value="CILA">Cila</option>
                                                    </select>
                                                </div>
                                                </div>
												<div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["NozzleNo"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                    <input disabled type="number" min="0" step="1" id="" name="NozzleNo" value="<?php echo $nozzleNumber;?>" class="form-control" onkeypress="return isNumberKey(event)">
                                                </div>
                                                </div>
                                                <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["StockID"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                    <input type="number" min="0" step="1" id="ProductID" name="ProductID" value="" class="form-control" onkeypress="return isNumberKey(event)">
                                                </div>
                                                </div>
                                                </div> 
												<div class="col-lg-6">
												<div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class="form-control-label"><?php echo $dil["tablePrice"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                    <input type="number" min="0" step="1" id="" name="price" placeholder="" class="form-control" onkeypress="return isNumberKey(event)">
                                                </div>
                                                </div>
												<div class="row form-group">
                                                 <div class="col col-md-6">
                                                    <label for="" class="form-control-label"><?php echo $dil["tableTime"];?></label>
                                                </div>
                                               <div class="col col-md-6">
                                                    <input type="number" min="0" step="1" id="" name="time" placeholder="" class="form-control" onkeypress="return isNumberKey(event)">
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                          </div>
                                  
                                    <div class="card-footer">
                                        <button type="submit" name="submit_nozzle"  id="submit_nozzle" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> Add 
                                        </button>
                                    </div>
                                    </form>
                                </div>                                
                            </div>                     
                        </div>
                        </div>
                    
     <script type="text/javascript">

        $("#submit_nozzle").on("click", function (event) {
	       
        event.preventDefault();
       
        var e = document.getElementById("type");
        var ProductName = e.options[e.selectedIndex].value;
        var MachineID = $('input[name="Address"]').val();
        var ProductID = $('input[name="ProductID"]').val();
            
        var Nozzle_No = $('input[name="NozzleNo"]').val();
      
        var ProductPrice = $('input[name="price"]').val();
        var ProductTime = $('input[name="time"]').val();
            /*if(ProductName=='SU')
                {
                var ProductID = 21635;
                    
                }
            else if(ProductName=='KOPUK')
                {
                var ProductID = 21636;
                    
                }
            else if(ProductName=='CILA')
                {
                var ProductID = 21637;
                    
                }*/
	    //var =$(this).attr('id');
            
        var JSON_Data = "{"+'"'+"MachineID"+'"'+":"+'"'+MachineID+'"'+","+'"'+"Nozzle_No"+'"'+":"+'"'+Nozzle_No+'"'+","+'"'+"ProductID"+'"'+":"+'"'+ProductID+'"'+","+'"'+"ProductName"+'"'+":"+'"'+ProductName+'"'+","+'"'+"ProductPrice"+'"'+":"+'"'+ProductPrice+'"'+","+'"'+"ProductTime"+'"'+":"+'"'+ProductTime+'"'+"}";
        $.ajax({
               url: "operation.php?islem=nozzle_ekle",
               type: "POST",
               data: "deger="+JSON_Data,
               success: function (cevap) {
				   JSalert_With_Redirect_Insert("./nozzle_list.php?Address="+MachineID);
				   
				   
				   /*swal({ title : "<?php echo $dil["insertTitle"];?>",
							text: "<?php echo $dil["insertMessage"];?>",
							type: "info"
				   },
				   function(){
					   window.location.href="./nozzle_list.php?Address="+MachineID;
				   });*/
				

 /*window.location.hrf="./nozzle_list.php?Address="+MachineID;*/

	       		 
                  
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
