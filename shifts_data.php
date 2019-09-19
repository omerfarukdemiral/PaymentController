 
 <?php
 session_start();
if(!$_SESSION["dil"]){
require("dil/en.php");
}
else{
require("dil/".$_SESSION["dil"].".php");
}
error_reporting(0);
 class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('/exec/YIKAMA/PaymentController_Configurations.db');
    }
}
$db = new MyDB();
$db->busyTimeout(5000);
$db-> exec('PRAGMA journal_mode=wal;');

if(!$db)
{
	echo $db->lastErrorMsg();
}
$query_sales = "SELECT SALES.SaleID, Nozzle_WashingMachine.ProductName, Nozzle_WashingMachine.ProductPrice,Nozzle_WashingMachine.ProductID, Nozzle_WashingMachine.ProductTime,SALES.SaleDate,SALES.SaleTime,SALES.PeronNo,SALES.TotalAmount,SALES.TotalTime, SALES.isTransferred, SALES.PaymentType,SalesItems.ProductPrice,SalesItems.NozzleNo,Nozzle_WashingMachine.ProductTime From SALES INNER JOIN SalesItems on Sales.SaleID = SalesItems.SaleID INNER JOIN Nozzle_WashingMachine on SALES.PeronNo = Nozzle_WashingMachine.MachineID WHERE SalesItems.NozzleNo== Nozzle_WashingMachine.Nozzle_No";

$Shift_query = "SELECT * FROM Shifts order by ID desc limit 1";
$shift = $db->query($Shift_query);

$Shift_row = $shift->fetchArray();

$ShiftBeginDate = $Shift_row["ShiftBeginDate"];
$ShiftBeginTime = $Shift_row["ShiftBeginTime"];
$Status = $Shift_row["Status"];
$ShiftEndDate = $Shift_row["ShiftEndDate"];
$ShiftEndTime = $Shift_row["ShiftEndTime"];
$Status = $Shift_row["Status"];
if($Status==1)
{
    $ShiftEnd = date("d.m.Y H:i:s");   
}
else{
    $ShiftEnd = date('d.m.Y H:i:s', strtotime("$ShiftEndDate $ShiftEndTime"));
}
 

$ShiftBegin = date("d.m.Y H:i:s", strtotime("$ShiftBeginDate $ShiftBeginTime"));

function getPaymentName($ID)
{
    $database_name = "/exec/YIKAMA/PaymentController_Configurations.db";

    $db = new SQLite3($database_name);
	$PaymentName ="";
	$query = "Select * FROM PaymentType WHERE ID=$ID";
	$result= $db->query($query);
	$result_payment = $result->fetchArray();
	$PaymentName = $result_payment['PaymentName'];
	return $PaymentName;
}
function getDateNumber($datevalue)
{
    $datetime = explode(' ', $datevalue);
$time = $datetime[1];
$date = $datetime[0];
$dates = explode('.', $date);
$times = explode(':', $time);

    $datenumber = $dates[2]."".$dates[1]."".$dates[0]."".$times[0]."".$times[1]."".$times[2];
    return $datenumber;

}
function getTransferred($ID){
    $stat ="";
    
    if($ID==1)
    {	if($_SESSION["dil"]=='en')
        $stat="Online";
    elseif($_SESSION["dil"]=='tr'){
        $stat="Online";
            }	
    }
    else{
            if($_SESSION["dil"]=='en')
        $stat="Offline";
    elseif($_SESSION["dil"]=='tr'){
        $stat="Offline";
            }	
    }
    
    return $stat;
}

    $ret = $db->query($query_sales);

while ($sale_row = $ret->fetchArray(SQLITE3_ASSOC))
{ $transferStat = getTransferred($sale_row['isTransferred']);
    $sale_type =getPaymentName($sale_row['PaymentType']);
        $new_row = array('isTransferred' =>$transferStat, 'PaymentType' =>$sale_type);
        if($sale_row['NozzleNo']==0)
        {
            
            $new_row2 = array('NozzleNo' =>"");
            $row = array_replace($sale_row, $new_row, $new_row2);

        }
        else
        {
            $row = array_replace($sale_row, $new_row);
        }
        $rows[] = $row;
}
//var_dump($rows);
$shift_sales['ShiftBegin'] = $ShiftBegin;
$shift_sales['ShiftEnd'] = $ShiftEnd;
$shift_sales['Status'] = $Status;
$shift_sales['TotalAmount'] = 0;
$shift_sales['TotalTime'] = 0;
$shift_sales['TotalSale'] = 0;
$SaleCount  = 0;
foreach ($rows as &$row) {
   $SaleDateTemp = $row['SaleDate'];
   $SaleTimeTemp = $row['SaleTime'];

$SaleDate = date("d.m.Y H:i:s", strtotime("$SaleDateTemp $SaleTimeTemp"));


if(getDateNumber($ShiftBegin)<getDateNumber($SaleDate) && getDateNumber($ShiftEnd)>getDateNumber($SaleDate))
{
    $shift_sales['TotalAmount'] =$shift_sales['TotalAmount'] + $row['TotalAmount'];
    $shift_sales['TotalTime'] =$shift_sales['TotalTime'] + $row['TotalTime'];
    $SaleCount+=1;
    $shift_rows[]=$row;
}

}

$shift_sales['TotalSale'] =  $SaleCount;

//var_dump($shift_rows);

$data1 =json_encode($shift_rows);
$json_shift_sales =json_encode($shift_sales);
if($json_shift_sales!="null")
{

    $yazdir ="\"datas\"";
    
    $json_shifts = $json_shift_sales;

 echo $json_shifts;
}
else{
    $response=0;
   header('HTTP/1.1 500 Iternal Server Error');
   die( $dil["RegisteredSales"]);
}
?>