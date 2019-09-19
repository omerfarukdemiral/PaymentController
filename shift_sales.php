<?php session_start();

if($_SESSION["login"]=='true'){
	include 'header.php';         

include "ayar.php";

$shiftNo = $_GET['ShiftName']; 
$query_shift = "SELECT * FROM Shifts WHERE ShiftName='$shiftNo'";
$result_shift = $db->query($query_shift);
$row_Shift = $result_shift->fetchArray();
$ShiftBeginDate = $row_Shift["ShiftBeginDate"];
$Status = $row_Shift["Status"];
if($Status==0)
{

    $ShiftEndDate = $row_Shift["ShiftEndDate"];
    $ShiftEndTime = $row_Shift["ShiftEndTime"];
}
else{
    $date = date("d.m.Y H:i:s");
    $dates = explode(" ", $date);
    $ShiftEndDate = $dates[0];
    $ShiftEndTime = $dates[1];
}
$parts = explode('.', $ShiftBeginDate);
$day = $parts[0];
$mount = $parts[1];
$year = $parts[2];
$ShiftBeginTime = $row_Shift["ShiftBeginTime"];
if(strlen($ShiftEndDate)>2)
{
    $endparts = explode('.', $ShiftEndDate);
    $day1 = $endparts[0];
    $mount1 = $endparts[1];
    $year1 = $endparts[2];
}
else{
    $ShiftEndDate =$ShiftBeginDate;
    $endparts = explode('.', $ShiftEndDate);
    $day1 = $endparts[0];
    $mount1 = $endparts[1];
    $year1 = $endparts[2];
}


$query_sales = "SELECT SALES.SaleID, Nozzle_WashingMachine.ProductName, Nozzle_WashingMachine.ProductPrice,Nozzle_WashingMachine.ProductID, Nozzle_WashingMachine.ProductTime,SALES.SaleDate,SALES.SaleTime,SALES.PeronNo,SALES.TotalAmount,SALES.TotalTime, SALES.isTransferred, SALES.PaymentType,SalesItems.ProductPrice,SalesItems.NozzleNo,Nozzle_WashingMachine.ProductTime From SALES INNER JOIN SalesItems on Sales.SaleID = SalesItems.SaleID INNER JOIN Nozzle_WashingMachine on SALES.PeronNo = Nozzle_WashingMachine.MachineID WHERE SalesItems.NozzleNo== Nozzle_WashingMachine.Nozzle_No";
$result_sales = $db->query($query_sales);

$query_ProductNo ="SELECT DISTINCT NozzleNo FROM SalesItems";
$result_ProductNo = $db->query($query_ProductNo);

$query_ProductName ="SELECT DISTINCT ProductName FROM Nozzle_WashingMachine";
$result_ProductName = $db->query($query_ProductName);

$query_PaymentType ="SELECT * FROM PaymentType";
$result_PaymentType = $db->query($query_PaymentType);


$query_PeronNo ="SELECT DISTINCT PeronNo FROM SALES";
$result_PeronNo = $db->query($query_PeronNo);





$query_sale_datefilter = "SELECT SALES.SaleID, Nozzle_WashingMachine.Produ	ctName,SALES.SaleDate,SALES.SaleTime,SALES.PeronNo,SALES.TotalAmount,SALES.TotalTime, SALES.isTransferred, SALES.PaymentType,SalesItems.NozzleNo From SALES INNER JOIN SalesItems on Sales.SaleID = SalesItems.SaleID INNER JOIN Nozzle_WashingMachine on SALES.PeronNo = Nozzle_WashingMachine.MachineID WHERE SalesItems.NozzleNo== Nozzle_WashingMachine.Nozzle_No AND SaleDate BETWEEN '03.05.2019' AND '04.05.2019' ";

?>
<script src="js/jquery.min.js"></script>
 <script type="text/javascript">
 
    window.onload=function(){
      
     $(document).ready(function(){
        var momentNow = moment();
        var todayDate = momentNow.format('DD.MM.YYYY');    
        
        var lang = "<?php echo $dil["lang"];?>";
         if(lang =='tr')
         {
            $("#min").datepicker({

                monthNames: [ "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık" ],
                monthNamesShort: [ "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık" ],
                dayNamesMin: [ "Pa", "Pt", "Sl", "Ça", "Pe", "Cu", "Ct" ],
                firstDay:1,
				onSelect: function () { 
                   
                    document.getElementById("startTime").value = "00:00:00";
                	$('#startTime').trigger('change');
                    document.getElementById("startTime").focus();
	
                },
				changeMonth: true, 
				changeYear: true, 
				dateFormat: "dd.mm.yy",
                setDate:  new Date("<?php  echo $ShiftBeginDate; ?>")                
                });
                
                $("#max").datepicker({
                monthNames: [ "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık" ],
                monthNamesShort: [ "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık" ],
                dayNamesMin: [ "Pa", "Pt", "Sl", "Ça", "Pe", "Cu", "Ct" ],
                firstDay:1,
                onSelect: function () { 
                 
                    document.getElementById("endTime").value = "23:59:59";

                    $('#endTime').trigger('change');
                    document.getElementById("endTime").focus();
                },
				changeMonth: true,
				changeYear: true,
				dateFormat: "dd.mm.yy",
                setDate:  new Date("<?php  echo $ShiftEndDate; ?>")                
				});
				
            }
            else if(lang =='en')
         {
            $("#min").datepicker({

				 onSelect: function () { 
                  
                    document.getElementById("startTime").value = "00:00:00";
                    
                    document.getElementById("startTime").focus();
                    
                },
				changeMonth: true, 
				changeYear: true, 
				dateFormat: "dd.mm.yy",
                
				});
                
                $("#max").datepicker({
                    onSelect: function () { 
                    
                    document.getElementById("endTime").value = "23:59:59";
                    $('#endTime').trigger('change');
                    document.getElementById("endTime").focus();
                },
				changeMonth: true,
				changeYear: true,
				dateFormat: "dd.mm.yy"
				});    
                
            }

            $("#min").datepicker().datepicker("setDate", new Date(<?php  echo $year; ?>,<?php  echo $mount-1; ?>,<?php  echo $day; ?>));
            $("#max").datepicker().datepicker("setDate", new Date(<?php  echo $year1; ?>,<?php  echo $mount1-1; ?>,<?php  echo $day1; ?>));
            document.getElementById("startTime").value = "<?php echo $ShiftBeginTime;?>";
            document.getElementById("endTime").value = "<?php echo $ShiftEndTime;?>";

        var table = $('#sales').DataTable({
		language: {
            "url": "datatable/<?php echo $dil["lang"];?>.json"
        },
       ordering: false,
	    paging: true,
        "ajax": {
                url: "sales_database.php",
                error: function(cevap){
                    window.location.href="index.php";
                    }
            },
        "columns": [
                {"data": "SaleDate"},
                { "data": "SaleTime"},
                 {"data": "PeronNo"},
                { "data": "NozzleNo"},
                {"data": "ProductName"},
<?php if($_SESSION["authority"]==1){ ?>       {"data": "ProductID"}, <?php } ?>
                { "data": "TotalAmount"},
                { "data": "TotalTime"},
                { "data": "PaymentType"},
                {"data": "isTransferred"}
            ],
		dom: 'Bfrtip',
		buttons: [
            'pageLength','excel', 'pdf', 'print'
        ],
        "search": {regex: true}		
		});
     
      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
	
            var min = $('#min').datepicker("getDate");
			var max = $('#max').datepicker("getDate");

            var minTime = $('#startTime').val();
            var maxTime = $('#endTime').val();


    if(min!=null)
        {if(minTime=="")
            {
             minTime="00:00:00";
            }
            var startHours = minTime.split(":"); 
        
            min.setHours(startHours[0]);
            min.setMinutes(startHours[1]);
            if(minTime.length>5)
            {
           min.setSeconds(startHours[2]);
            }
}
        if(max!=null)
        {      if(maxTime=="")
            {
                        maxTime="23:59:59";
            
            }  
            var endHours = maxTime.split(":"); 
            max.setHours(endHours[0]);
            max.setMinutes(endHours[1]);
            if(maxTime.length>5)
            {
            max.setSeconds(endHours[2]);
            }
        }
                   
            var startDate = new Date(data[0].split(".")[2],data[0].split(".")[1]-1,data[0].split(".")[0]);
            var startDate_Times = data[1].split(":"); 
            startDate.setHours(startDate_Times[0]);
            startDate.setMinutes(startDate_Times[1]);
            startDate.setSeconds(startDate_Times[2]);

		    if (min == null && max == null) { return true; }
            if (min == null && startDate <= max) { return true;}
            if(max == null && startDate >= min) {return true;}
            if (startDate <= max && startDate >= min) { return true; }
            return false;
        });

			 
	
		
$('#peronNo').change(function(){
	if ( table.column(2).search() !== this.value ) {
                table
                    .column(2)
                    .search( this.value )
                    .draw();
            }
        
});

$('#NozzleNo').change(function(){
	if ( table.column(3).search() !== this.value) {
                table
                    .column(3)
                    .search( this.value)
                    .draw();
            }
});

$('#ProductName').change(function(){
    if ( table.column(4).search() !== this.value ) {
             table
                .column(4)
                .search( this.value )
                .draw();  
    }          
});

$('#PaymentType').change(function(){
	if ( table.column(8).search() !== this.value ) {
                table
                    .column(8)
                    .search( this.value )
                    .draw();
            }
});



$('#status').change(function(){
	if ( table.column(9).search() !== this.value ) {
                table
                    .column(9)
                    .search( this.value )
                    .draw();
            }
});
let  current_datetime = new Date();
let start_date = new Date();
let end_date = new Date();


$('#startTime').change(function(){
  
    table.draw();
});

$('#endTime').change(function(){
  
  table.draw();
});
        });
	
    }
	
</script>

	<!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    
                   <div class="container-fluid">
				   <div class="row">
							 <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                    <strong>  <?php echo $dil["shiftNo"];?>  <?php echo $shiftNo;?></strong> |    <?php echo $dil["menu2"];?>    
                                        <button  class="btn btn-primary btn-sm"  style="float:right;" onclick="resetFilter()">
                                            <i class="fa fa-refresh"> </i><?php echo "  ".$dil["Reset"];?>
										</button>  
									</div>
                                      <form  method="POST" class="form-horizontal" action="" >
                                      
                                    <div class="card-body card-block">
                                        <div class="row">
                                            <div class="col-lg-6">
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["PeronNo"];?></label>
                                                </div>
												<div class="col col-md-6">
												<select name="peronNo" id="peronNo" class="form-control">
												<option value="" selected><?php echo $dil["All"];?></option>

												<?php while($row = $result_PeronNo->fetchArray()) {?>                                                     
													 <option value="<?php echo $row['PeronNo']?>"><?php echo $row['PeronNo']?></option>
                                                     <?php } ?>   
                                                </select> 
                                                </div>  
                                                </div>  
												<div class="row form-group">
												<div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["NozzleNo"];?></label>
                                                </div>
												  <div class="col col-md-6">
												<select name="NozzleNo" id="NozzleNo" class="form-control">
												<option value="" selected><?php echo $dil["All"];?></option>
													<?php while($row = $result_ProductNo->fetchArray()) { if($row['NozzleNo']!=0) {?>                                                     
												<option value="<?php echo $row['NozzleNo']?>"><?php echo $row['NozzleNo']?></option>
                                                     <?php }} ?>   
                                                </select>                                                 
												</div>
												</div>
												<div class="row form-group">
												<div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["ProductName"];?></label>
                                                </div>
												<div class="col col-md-6">
												<select name="ProductName" id="ProductName" class="form-control">
													<option value="" selected><?php echo $dil["All"];?></option>
													<?php while($row = $result_ProductName->fetchArray()) {?>                                                     
													 <option value="<?php echo $row['ProductName']?>"><?php echo $row['ProductName']?></option>
                                                     <?php } ?>   
                                                </select>                                           
												</div>
												</div>
												
                                            <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["PaymentType"];?></label>
                                                </div>
												
                                                <div class="col col-md-6">
													<select name="PaymentType" id="PaymentType" class="form-control">
													<option value="" selected><?php echo $dil["All"];?></option>
													<?php while($row = $result_PaymentType->fetchArray()) {?>                                                     
													<option value="<?php echo $row['PaymentName'];?>"><?php echo $row['PaymentName'];?></option>
                                                    <?php } ?>   
													</select> 
                                                </div>
                                               
                                            </div>
											<div class="row form-group">
												 <div class="col col-md-4">
                                                    <label for="" class="form-control-label"><?php echo $dil["TransferStatus"];?></label>
                                                </div>                                               
											 
												
                                                <div class="col col-md-6">
												<select name="status" id="status" class="form-control">
												<option value="" selected><?php echo $dil["All"];?></option>
												<option value="Online"><?php echo $dil["online"];?></option>
												<option value="Offline"><?php echo $dil["offline"];?></option>
                                                </select>  
                                                </div>
												
                                            </div>
                                            </div>
											
											  <div class="col-lg-6">
											  <div class="row form-group">
                                                <div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["startDate"];?></label>
                                                </div>
												
												<div class="col col-md-6">
												    <div class="input-group">
												   <input type="text" id="min" name="min" class="form-control" autocomplete="off" disabled>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
												</div>
												</div>
												 <div class="row form-group">
												
												<div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["startTime"];?></label>
                                                </div>
												 <div class="col col-md-6">
												    <div class="input-group">
												   <input type="time" id="startTime" name="startTime" class="form-control" autocomplete="off"  step="1" disabled>
                                                    <div class="input-group-addon">
                                                        <i class="far fa-clock"></i>
                                                    </div>
                                                </div>
												</div>
												</div>
												 <div class="row form-group">
												<div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["endDate"];?></label>
                                                </div>
												 <div class="col col-md-6">
												    <div class="input-group">
												   <input type="text" id="max" name="max" class="form-control" autocomplete="off" disabled>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
												</div>
												</div>
											  <div class="row form-group">
											         <div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["endTime"];?></label>
                                                    </div>
                                                <div class="col col-md-6">
												    <div class="input-group">
												        <input type="time" id="endTime" name="endTime" class="form-control" autocomplete="off"  step="1" disabled>
                                                         <div class="input-group-addon">
                                                            <i class="fas fa-clock"></i>
                                                        </div>
                                                    </div>
												</div>
                                            </div>
                                             <div class="row form-group">
                                             <div class="col col-md-4">
                                                    <label for="" class=" form-control-label"><?php echo $dil["shiftStatus"];?></label>
                                                    </div>
                                                <div class="col col-md-8">
												    <div class="input-group">
                                                        <?php if($Status==1)
                                                        {?>

                                                            <div class="alert alert-success " role="alert">
                                                            <?php echo $dil["shiftOpen"];?> 
                                                            </div>
                                                       <?php } else
                                                       {?>
                                                        <div class="alert alert-danger " role="alert">
                                                            <?php echo $dil["shiftClose"];?> 
                                                            </div>
                                                       <?php }  ?>
                                                   
                                                    </div>
												</div>
                                            </div>
                                          </div>
                                          </div>                       
                                          </div>                       
                                    </form>
                                                  
                                    

                       <div class="col-md-12" style="background-color: #e5e5e5; ">
                   <div class="table-responsive m-b-40">
                                                 
         <table id="sales" class="table table-striped table-bordered" style="" >
				<thead>
				<tr>
                                              
                                    <th style="width: 20%"><?php echo $dil["saleDate"];?></th>
                                    <th style="width: 20%"><?php echo $dil["saleTime"];?></th>
                                    <th style="width: 10%"><?php echo $dil["PeronNo"];?></th>
                                    <th style="width: 15%"><?php echo $dil["NozzleNo"];?></th>
                                    <th style="width: 20%"><?php echo $dil["ProductName"];?></th>
<?php if($_SESSION["authority"]==1){  ?><th style="width: 15%"><?php echo $dil["tableProductID"];?></th><?php }?>
                                    <th style="width: 15%"><?php echo $dil["tableAmount"];?></th>
                                    <th style="width: 15%"><?php echo $dil["tableTime"];?></th>
                                    <th style="width: 20%"><?php echo $dil["PaymentType"];?></th>
                                    <th style="width: 15%"><?php echo $dil["TransferStatus"];?></th>
                 </tr>
				</thead>
     
      
    </table>
                              
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>

      <script type="text/javascript">
	  
	  	

</script>

<script type="text/javascript">

function resetFilter() {
	    
	document.getElementById("peronNo").selectedIndex = "0";
	$('#peronNo').trigger('change');
	document.getElementById("NozzleNo").selectedIndex = "0";
	$('#NozzleNo').trigger('change');
	document.getElementById("ProductName").selectedIndex = "0";
	$('#ProductName').trigger('change');
	document.getElementById("PaymentType").selectedIndex = "0";
	$('#PaymentType').trigger('change');
	document.getElementById("status").selectedIndex = "0";
	$('#status').trigger('change');



}



    </script> 


<?php include 'footer.php'; }
else
{
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>         
