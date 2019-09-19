
<?php 
session_start();

if($_SESSION["login"]=='true' && $_SESSION["authority"]==1){
include 'header.php';         

$message = ""; 
include "ayar.php";

//$ID = $_GET['ID']; 
$ID = 1; 


$query = "Select Count(*) from WashingMachine"; 
$result = $db->query($query);
 while($row = $result->fetchArray()) {
       $Address = $row['Count(*)']+1;
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
                                        <strong><?php echo $dil["licence"];?></strong>
                                    </div>
                                      <form  method="POST" class="form-horizontal" >
                                     <div class="card-body card-block">
                                            <div class="row">
                                            <div class="col-lg-6">
                                            <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["tableAddress"];?></label>
                                                </div>
                                                <div class="col col-md-6">
                                                    <input type="number" min="3" step="45" id="parametre" name="parametre" placeholder="" class="form-control" onkeypress="return isNumberKey(event)" autocomplete="off">
                                                </div>
                                                </div>
                                         </div>
                                       </div>
										
								</div>
								
								   <div class="card-footer">
                                        <button type="submit" name="submit_machine" id="submit_machine" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> <?php echo $dil["AddMachineButton"];?> 
                                        </button>

                                    </div>
                                    </form>
								</div>
                                  
                                 
                                                   
                        </div>
                        </div>
                        </div>
                        </div>
                    <script type="text/javascript">

        $("#submit_machine").on("click", function (event) {
	       
        event.preventDefault();
		var Address = $('input[name="Address"]').val();
		if(Address>0)
		{
        var ID =1;
        var e = document.getElementById("PortID");
        var Port = e.options[e.selectedIndex].value;
        var Address = $('input[name="Address"]').val();
       // var ProductNo = $('input[name="ProductNo"]').val();
      
        var RepeatCount = $('input[name="RepeatCount"]').val();
        var WakeUpCount = $('input[name="WakeUpCount"]').val();
        var e = document.getElementById("Status");
        var Status = e.options[e.selectedIndex].value;
            //var zaman = document.getElementById("datetime").value;
             //$("datetime").text(2);
            //alert(zaman);
        var dt = new Date();
        var longdate= (("0"+dt.getDate()).slice(-2)) +"."+ (("0"+(dt.getMonth()+1)).slice(-2)) +"."+ (dt.getFullYear()) +" - "+ (("0"+dt.getHours()).slice(-2)) +":"+ (("0"+dt.getMinutes()).slice(-2)) + ":"+  (("0"+dt.getSeconds()).slice(-2));

            var zaman = longdate.split(' - ');
            var Tarih = zaman[0];
            var Saat = zaman[1];
         
        var JSON_Data = "{"+'"'+"Address"+'"'+":"+'"'+Address+'"'+","+'"'+"Port"+'"'+":"+'"'+Port+'"'+","+'"'+"RepeatCount"+'"'+":"+'"'+RepeatCount+'"'+","+'"'+"WakeUpCount"+'"'+":"+'"'+WakeUpCount+'"'+","+'"'+"Status"+'"'+":"+'"'+Status+'"'+","+'"'+"Date"+'"'+":"+'"'+Tarih+'"'+","+'"'+"Time"+'"'+":"+'"'+Saat+'"'+"}";
        $.ajax({
               url: "operation.php?islem=machine_save",
               type: "POST",
               data: "deger="+JSON_Data,
               success: function (cevap) {
	       		if(cevap==0)
                    {
                        JSalert_Warning();
               window.location.href="./machine_add.php?ID="+ID;
                    }
                   else{
                    JSalert_With_Redirect_InsertMachine("./machine_list.php?ID="+ID,cevap);
            
				  
                    }
        
               }
           });
		}
		else{
			   
			   JSalert_Warning_Message("<?php echo $dil["AddressEmpty"];?>");
		   }
			   
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
                                   JSalert_Warning_Message("<?php echo $dil["AddressChange"];?>");
                                      
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
                    
  <script>
                    
 </script>
                    
				
<?php include 'footer.php'; }
else
{ 	echo  $_SESSION["login"];
	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>