 
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
$data1 =json_encode($rows);
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