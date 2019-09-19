<?php session_start();
error_reporting(0);
if($_SESSION["login"]=='true' && $_SESSION["authority"]==1){
	include 'header.php';         

$message = ""; 
include "ayar.php";

$Address = $_GET['Address']; 
$query = "SELECT * FROM Nozzle_WashingMachine WHERE MachineID='$Address'";

/*$resultAddress = $db->query($queryAddress);
 while($row = $resultAddress->fetchArray()) {
 $Address= $row['Address']; 

 }*/


$result = $db->query($query);
$query2 = "SELECT ID, * FROM Controller";
$ID="";
$result = $db->query($query2);
while($row = $result->fetchArray()) {
    $ID=$row['ID'];
}
?>
<script type="text/javascript">
var table;
window.onload = function() {

    $(document).ready(function() {

        table = $('#nozzle_list').DataTable({

            language: {
                "url": "datatable/<?php echo $dil["lang"];?>.json",
                "emptyTable":     "My Custom Message On Empty Table"
            },
            ordering: false,
            paging: false,
            searching : false,
            "processing": true,
            "ajax": {
                url: "nozzle_database.php?Address=<?php echo $Address;?>",
                error: function(cevap){
                    window.location.href="machine_list.php?ID=<?php echo $ID;?>";
                    }
            },
                  
            "columns": [
                {"data": "ID"},
                { "data": "MachineID"},
                {"data": "Nozzle_No"},
                { "data": "ProductName"},
                {"data": "ProductPrice"},
                {"data": "ProductID"},
                { "data": "ProductTime"},
                {"data": "myDummyData"}
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": "myDummyData",
                    "defaultContent": '<div class="table-data-feature"><button class="Update_Nozzle" title="<?php echo $dil["update"];?>" name="Update_Nozzle"><i class="zmdi zmdi-edit" style="color:#0056b3; font-size:30px;   "></i> </button><button class="Delete_Nozzle" title="<?php echo $dil["delete"];?>" name="Delete_Nozzle"><i class="fa fa-trash" style="color:#ff0000; font-size:30px;"></i> </button></div>'
                },
                {
                    "targets": [0],
                    "visible": false
                }
            ]

        });

        $('#nozzle_list tbody').on('click', 'button', function() {
            event.preventDefault();
            var tempData = table.row($(this).parents('tr')).data();
            var actionName = $(this).attr('name');

            if (actionName == 'Delete_Nozzle') {
                $.ajax({
                    url: "operation.php?islem=nozzle_sil",
                    type: "POST",
                    data: {'NozzleID': tempData['ID']},
                    success: function(cevap) {                  
                      table.ajax.reload();
                    },
                    error: function(cevap){
                        JSalert_Warning_Message("<?php echo $dil["RegisteredSales"]?>");
                    }
                });
            } else if (actionName == "Update_Nozzle") {
                window.location.href = "./nozzle_update.php?ID=" + tempData['ID'];
            }
        });


/*
 #region DelenteNozzle Comment
        /*$(".Delete_Nozzle").on("click", function (event) {
	       
        event.preventDefault();
     

      //  var NozzleID  = $('button[name="Delete_Nozzle"]').id();
            var NozzleID=$(this).attr('id');
    
        $.ajax({
               url: "operation.php?islem=nozzle_sil",
               type: "POST",
            data :{'NozzleID':NozzleID},
               success: function (cevap) {
	      	     alert("succcess");
	       		
				}
           });
        });*/
//#endregion

    });

}
</script>
<!-- HEADER DESKTOP-->

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="nozzle_add.php?Address=<?php echo $Address?>">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i><?php echo $dil["AddNozzleButton"];?>
                                </button></a>
                        </div>
                    <br>
                    <!-- DATA TABLE-->
                        <div class="table-responsive m-b-40">
                      
                            <table class="table table-striped table-bordered" id="nozzle_list">
                                <thead>
                                    <tr>
                                        <th hidden>ID</th>
                                        <th><?php echo $dil["tableAddressNozzle"];?></th>
                                        <th><?php echo $dil["NozzleNo"];?></th>
                                        <th><?php echo $dil["ProductName"];?></th>
                                        <th><?php echo $dil["tablePrice"];?></th>
                                        <th><?php echo $dil["tableProductID"];?></th>
                                        <th><?php echo $dil["tableTime"];?></th>
                                        <th><?php echo $dil["tableAction"];?></th>

                                    </tr>
                                </thead>

                            </table>
                        </div>
                        <!-- END DATA TABLE-->
                </div>
			</div>

            </div>
        </div>



        <?php include 'footer.php'; }
else
{ 	echo  $_SESSION["login"];
	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>