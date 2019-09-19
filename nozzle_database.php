 
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


$Address = $_GET['Address']; 
$query = "SELECT * FROM Nozzle_WashingMachine WHERE MachineID=$Address AND Nozzle_No>0";

$ret = $db->query($query);

while ($row = $ret->fetchArray(SQLITE3_ASSOC))
{
    
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