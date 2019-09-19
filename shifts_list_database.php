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

  -RNO ( Receipt No )
          -SALES_DATE
          -SALES_CLOCK
          -UNIT_PRC
          -SALES_LITER
          -SALES_AMOUNT
          -BEGIN_TOTAL_VOLUME
          -END_TOTAL_VOLUME
          -CustomerRFID
          -PersonRFID
          -PLATE
          -STATUS


function getDateNumber($datevalue)
{
    $datetime = explode(' ', $datevalue);
$time = $datetime[1];
$date = $datetime[0];
$dates = explode('.', $date);
$times = explode(':', $time);

    $datenumber = $dates[2]."".$dates[1]."".$dates[0]."".$times[0]."".$times[1]."".$times[2];
   // echo $datenumber; 
    return "<br>function Datenumber : ".$datenumber;

}
$db = new MyDB();
$db->busyTimeout(5000);
$db-> exec('PRAGMA journal_mode=wal;');

if(!$db)
{
	echo $db->lastErrorMsg();
}
$query_sales = "SELECT SALES.SaleID, Nozzle_WashingMachine.ProductName, Nozzle_WashingMachine.ProductPrice,Nozzle_WashingMachine.ProductID, Nozzle_WashingMachine.ProductTime,SALES.SaleDate,SALES.SaleTime,SALES.PeronNo,SALES.TotalAmount,SALES.TotalTime, SALES.isTransferred, SALES.PaymentType,SalesItems.ProductPrice,SalesItems.NozzleNo,Nozzle_WashingMachine.ProductTime From SALES INNER JOIN SalesItems on Sales.SaleID = SalesItems.SaleID INNER JOIN Nozzle_WashingMachine on SALES.PeronNo = Nozzle_WashingMachine.MachineID WHERE SalesItems.NozzleNo== Nozzle_WashingMachine.Nozzle_No";

$query = "SELECT * FROM Shifts";
$shift = $db->query($query);
$ret = $db->query($query_sales);

while ($shift_row = $shift->fetchArray(SQLITE3_ASSOC))
{
    if($shift_row['Status']==0)
    {
        $new_row = array('Status' =>$dil['shiftClose']);
        $row = array_replace($shift_row, $new_row);

    }
    else{
        $new_row = array('Status' =>$dil['shiftOpen']);
        $row = array_replace($shift_row, $new_row);

    }
    
        $shift_rows[] = $row;
}

foreach ($shift_rows as &$row) {

$ShiftBeginDate = $row["ShiftBeginDate"];
$ShiftBeginTime = $row["ShiftBeginTime"];
$ShiftEndDate = $row["ShiftEndDate"];
$ShiftEndTime = $row["ShiftEndTime"];
$Status = $row["Status"];
$TotalAmount=0;
$TotalTime = 0;
$TotalSale = 0;
$SaleCount  = 0;

$ShiftBegin = date("d.m.Y H:i:s", strtotime("$ShiftBeginDate $ShiftBeginTime"));

if($Status==1)
{
    $ShiftEnd = date("d.m.Y H:i:s");   
}
else{
    $ShiftEnd = date('d.m.Y H:i:s', strtotime("$ShiftEndDate $ShiftEndTime"));
}
    while ($sale_row = $ret->fetchArray(SQLITE3_ASSOC))
    { 
        $SaleDateTemp = $sale_row['SaleDate'];
        $SaleTimeTemp = $sale_row['SaleTime'];
        $SaleDate = date('d.m.Y H:i:s', strtotime("$SaleDateTemp $SaleTimeTemp"));
        $ShiftBeginNumber=getDateNumber($ShiftBegin);
        $SaleDateNumber=getDateNumber($SaleDate);
        $ShiftEndNumber=getDateNumber($ShiftEnd);

        if($ShiftBeginNumber<$SaleDateNumber && $ShiftEndNumber>$SaleDateNumber)
        {
                $TotalAmount+= $sale_row['TotalAmount'];
                $TotalTime+= $sale_row['TotalTime'];
                $SaleCount+=1;
        }          
    }

    $row['TotalAmount'] =  $TotalAmount;
    $row['TotalTime'] =  $TotalTime;
    $row['TotalSale'] =  $SaleCount;
   
    $shift_sales_rows[] = $row;
    $TotalAmount=0;
    $TotalTime = 0;
    $SaleCount  = 0;
}


$data1 =json_encode($shift_sales_rows);
if($data1!="null")
{

    $yazdir ="\"data\"";
    
   echo "{".$yazdir.":".$data1."}";
}
else{
             $response=0;
			header('HTTP/1.1 500 Iternal Server Error');
			die( $dil["RegisteredSales"]);
}


?>