<?php session_start();

if($_SESSION["login"]=='true' && $_SESSION["authority"]==1){
include 'header.php';         

include "ayar.php";

$query = "SELECT * FROM PortSettings";

$resultAddress = $db->query($query);
 while($row = $resultAddress->fetchArray()) {

 }


$result = $db->query($query);

?>

	<!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">     
                   <div class="container-fluid">
                    <div class="row ">
                        <div class="col-md-12">
							
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-striped table-bordered table-data3">
                                        <thead>
                                            <tr>
                                                <th hidden>ID</th>
                                                <th>No</th>
                                                <th><?php echo $dil["PortName"];?></th>
                                                <th><?php echo $dil["Baud"];?></th>
                                                <th><?php echo $dil["Databit"];?></th>
                                                <th><?php echo $dil["Parity"];?></th>
                                                <th><?php echo $dil["tableAction"];?></th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php while($row = $result->fetchArray()) {?>
                                   <tr>
				                    	<td hidden><?php echo $row['ID'];?></td>
				                    	<td><?php echo $row['ID'];?></td>
				                    	<td><?php echo $row['Name'];?></td>
				                        <td><?php echo $row['Baud'];?></td>
				                        <td><?php echo $row['DataBit'];?></td>
				                        <td><?php echo $row['Parity'];?></td>
                                        <td>
                                          <div class="table-data-feature">
                                             
                                                <a href="./port_update.php?ID=<?php echo $row['ID']; ?>" > <button id="" name="" class="item" data-toggle="tooltip" data-placement="top" title="<?php echo $dil["edit"];?>">
                                                   <i class="zmdi zmdi-edit" style="color:#0056b3;  "></i>
                                         </button></a>
                                              
                                              
                                          </div>
                                     </td>      
                                                            
			                       </tr>
			                         <?php } ?>
										</tbody>
                                    </table>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
				
							
                    </div>
                    </div>
                    				
<script type="text/javascript">

        $(".Delete_Nozzle").on("click", function (event) {
	       
        event.preventDefault();
     

      //  var NozzleID  = $('button[name="Delete_Nozzle"]').id();
            var NozzleID=$(this).attr('id');
    
        $.ajax({
               url: "operation.php?islem=nozzle_sil",
               type: "POST",
            data :{'NozzleID':NozzleID},
               success: function (cevap) {
	       		
	       		window.location.reload()
                   alert(cevap);
	       		
        
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
