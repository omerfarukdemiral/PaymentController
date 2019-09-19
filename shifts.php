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

$queryShiftList = "SELECT * FROM Shifts";

$resultShifts = $db->query($queryShiftList);
 while($row = $resultShifts->fetchArray()) {

 }
?>
	<!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    
                   <div class="container-fluid">

                    <div class="row ">
                        <div class="col-md-12">
                        <div class="card">
                                    <div class="card-header">
                                        <strong><?php echo $dil["shiftStatus"];?></strong>
                                        <input hidden type="number" min="0" step="1" value="<?php echo $shiftStatus;?>" type="text" id="Status" name="Status" placeholder="" class="form-control">
                                        <input hidden value="" type="text" id="ShiftDate" name="ShiftDate" placeholder="" class="form-control">

                                    </div>
                                    <div class="card-body">
                                    <div class="row ">  
                                        <div class="col-12 col-md-8">
                                        <div class="row "> 
                                        <div class="col-12 col-md-4">
                                        <button id="sorgula"  name="sorgula" type="button" class="btn-lg btn-primary" onclick="JSalert_ShiftStatus();"><?php echo $dil["shiftStatus"];?></button>
                                        </div>
                                        <div class="col-12 col-md-4">
                                         <button id="shiftOpen"<?php if($shiftStatus==1){?> disabled <?php  }?>  type="button" class="btn-lg btn-success"><?php echo $dil["shiftOp"];?></button> 
                                        </div>
                                        <div class="col-12 col-md-4">
                                        <button type="button"   id="shiftClose" <?php if($shiftStatus==0){?> disabled <?php  }?>  class="btn-lg btn-danger"><?php echo $dil["shiftCl"];?></button>
                                         </div>
                                    </div>                                    
                                    </div>                                    
                                    </div>                                    
                                </div>
                         
                   
                  <section class="statistic statistic2">
                        <div class="container">
                        <div class="row">
                    
                        <div class="col-md-6 col-lg-3">
                                <div class="statistic__item statistic__item--red">
                                    <h2 class="number" id="TotalSale"></h2>
                                    <span class="desc"><?php echo $dil["TotalSale"];?></span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item--blue">
                                    <h2 class="number" id="TotalAmount"></h2>
                                    <span class="desc"><?php echo $dil["totalSaleAmount"];?></span>
                                    <div class="icon">
                                        <i class="fas fa-lira-sign"></i>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-6 col-lg-3">
                                <div class="statistic__item statistic__item--green">
                                    <h2 class="number" id="TotalTime"></h2>
                                    <span class="desc"><?php echo $dil["totalTime"]. " (".$dil["seconds"].")";?></span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-time-restore"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="statistic__item statistic__item--orange">
                                <span class="desc" class="number" id="shiftDate" style ="font-size:20px; color:white;" > </span><br>
                                    <span class="desc"><?php echo $dil["tableDate"];?></span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-time"></i>
                                    </div>
                                </div>
                            </div>
                            </div>

                    </div>
                    </section>
                
                           </div> 
                        </div>
                        </div>
                
              
             <div class="row ">
               <div class="col-md-12">
             <div class="card">
                    <!-- DATA TABLE-->
                    <div class="col-md-12" style="background-color: #f1f1f1; ">
                        <div class="table-responsive m-b-40">
                      
                            <table class="table table-striped table-bordered " id="shifts_list">
                                <thead>
                                    <tr>
                                        <th><?php echo $dil["shiftNo"];?></th>
                                        <th><?php echo $dil["shiftBeginDate"];?></th>
                                        <th><?php echo $dil["shiftBeginTime"];?></th>
                                        <th><?php echo $dil["shiftEndDate"];?></th>
                                        <th><?php echo $dil["shiftEndTime"];?></th>
                                        <th><?php echo $dil["TotalSale"];?></th>
                                        <th><?php echo $dil["totalSaleAmount"];?></th>
                                        <th><?php echo $dil["totalTime"];?></th>
                                        <th><?php echo $dil["shiftStatus"];?></th>
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
				
              
              				 
                       <script src="./js/ipaddress-validation.js"></script>
                       <script type="text/javascript">
var table;
window.onload = function() {

    get_Shift_Sales();

    $(document).ready(function() {

        table = $('#shifts_list').DataTable({

            language: {
                "url": "datatable/<?php echo $dil["lang"];?>.json",
                "emptyTable":     "My Custom Message On Empty Table"
            },
            ordering: true,
           /* "order": [[0,"desc" ]],*/
            paging: true,
            searching: false,
            "processing": true,
            "ajax": {
                url: "shifts_list_database.php",
                error: function(cevap){
                   $('#shiftOpen').trigger('click');
                    }
            },
                  
            "columns": [
               
                { "data": "ShiftName"},
                { "data": "ShiftBeginDate"},
                {"data": "ShiftBeginTime"},
                { "data": "ShiftEndDate"},
                {"data": "ShiftEndTime"},
                {"data": "TotalSale"},
                {"data": "TotalAmount"},
                {"data": "TotalTime"},
                {"data": "Status"},
                {"data": "myDummyData"}
           
               
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": "myDummyData",
                    "defaultContent": '<div class="table-data-feature"><button  class="btn btn-primary" title="<?php echo $dil["showSale"];?>" name="Show_Sales"><?php echo $dil["showSale"];?></button></div>'
                }
                
            ]
        });

        $('#shifts_list tbody').on('click', 'button', function() {

            event.preventDefault();
            var tempData = table.row($(this).parents('tr')).data();
            var actionName = $(this).attr('name');

if (actionName == 'Show_Sales') {

    window.location.href = "./shift_sales.php?ShiftName=" + tempData['ShiftName'];

}
                
            
        });
    });

}
</script>
 <script type="text/javascript">

function JSalert_ShiftStatus(){  
   

           $.ajax({ 
        	url: "shifts_database.php",
        	type: 'post',
        	success: function(response) {
         var obj = JSON.parse(response);
         if(obj.Status==1)
         {
           ShiftDate  = obj.ShiftBeginDate; 
           ShiftTime  = obj.ShiftBeginTime; 
           ShiftName = obj.ShiftName;
         }
         else{
           ShiftDate  = obj.ShiftEndDate; 
           ShiftTime  = obj.ShiftEndTime;   
             }

    if(obj.Status==1){
            swal({        
              title : ShiftName +" | "+"<?php echo $dil["shiftOpenStatus"];?>",
              text: ShiftDate+ " - " + ShiftTime,
              type: "success"
               });
        }
        else{
            swal({ 
               title : "<?php echo $dil["shiftCloseStatus"];?>",
               type: "error"
               }); 
        }}
      });
}


function get_Shift_Sales()
{ 
          $.ajax({ 
          url: "shifts_data.php",
          type: 'post',
          dataType: 'json',
          success: function(response) {

        
            if(response.Status==1)
            {
            document.getElementById("shiftDate").innerHTML = response.ShiftBegin;

            }
            else{
            document.getElementById("shiftDate").innerHTML = response.ShiftBegin+'<br>' +response.ShiftEnd;

            }
            document.getElementById("TotalTime").innerHTML = response.TotalTime;
            document.getElementById("TotalAmount").innerHTML = response.TotalAmount;
      
            document.getElementById("TotalSale").innerHTML = response.TotalSale;
    }
      });
}   

            </script>
              
			
<script type="text/javascript">





   $("#shiftOpen").on("click", function (event) {
	       
           event.preventDefault();
           var momentNow = moment();
             
             var tarih = momentNow.format('DD.MM.YYYY');
           var saat = momentNow.format('HH:mm:ss');
           $("#Status").val("1");
           var Status = $('input[name="Status"]').val();
       
           var JSON_Data = "{"+'"'+"Status"+'"'+":"+'"'+Status+'"'+","+'"'+"tarih"+'"'+":"+'"'+tarih+'"'+","+'"'+"saat"+'"'+":"+'"'+saat+'"'+"}";
           $.ajax({
                  url: "operation.php?islem=shift_insert",
                  type: "POST",
                  data: "deger="+JSON_Data,
                  success: function (cevap) {
                      
                    
                    JSalert_Insert_Message(cevap);
                   
                      
           
                  }
              });
              document.getElementById("shiftClose").disabled = false;
              document.getElementById("shiftOpen").disabled = true;
              function updateDiv()
               { 
              $( "#vardiyaHeader" ).load(window.location.href + " #vardiyaHeader" );
                }
                updateDiv();
                table.ajax.reload();
                get_Shift_Sales();

           });
           
           $("#shiftClose").on("click", function (event) {
	       
           event.preventDefault();
           var momentNow = moment();
             
             var tarih = momentNow.format('DD.MM.YYYY');
           var saat = momentNow.format('HH:mm:ss');
           $("#Status").val("0");
           var Status = $('input[name="Status"]').val();
          
           var JSON_Data = "{"+'"'+"Status"+'"'+":"+'"'+Status+'"'+","+'"'+"tarih"+'"'+":"+'"'+tarih+'"'+","+'"'+"saat"+'"'+":"+'"'+saat+'"'+"}";
           $.ajax({
                  url: "operation.php?islem=shift_update",
                  type: "POST",
                  data: "deger="+JSON_Data,
                  success: function (cevap) {
                      
                    
                    JSalert_Insert_Message(cevap);
                   
                      
           
                  }
              });
              document.getElementById("shiftClose").disabled = true;
              document.getElementById("shiftOpen").disabled = false;
              function updateDiv()
               { 
              $( "#vardiyaHeader" ).load(window.location.href + " #vardiyaHeader" );
                }
                updateDiv();
                table.ajax.reload();
                get_Shift_Sales();

            });
  

</script>
                   
          
				
<?php include 'footer.php'; }
else
{ 	echo  $_SESSION["login"];
	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>      

