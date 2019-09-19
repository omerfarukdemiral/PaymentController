<?php
 session_start();
if(!$_SESSION["dil"]){
require("dil/en.php");
}
else{
require("dil/".$_SESSION["dil"].".php");
}
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
//$response_array['status']='success';

function getMacAddress(){
exec("/sbin/ifconfig eth0 | grep HWaddr", $Mac);
$MacAddress=str_replace(':','',$Mac);

			
$MacAdd =$MacAddress[0];
$MacAdd =explode(' ', $MacAdd);
$MacAddress = strtoupper($MacAdd[10]);
return $MacAddress;
}


function newConf($ID){ 

	$db = new MyDB();
	$db->busyTimeout(5000);
$db-> exec('PRAGMA journal_mode=wal;');
    $Address = $db->querySingle("SELECT MachineID from Nozzle_WashingMachine where ID ==$ID");
    $db->querySingle("UPDATE WashingMachine set hasNewConf='1' WHERE Address=$Address");
    
}

function newConfBarcode($MachineNo){ 

	$db = new MyDB();
	$db->busyTimeout(5000);
$db-> exec('PRAGMA journal_mode=wal;');
    $db->querySingle("UPDATE BarcodeScanner set hasNewConf='1' WHERE MachineNo=$MachineNo");
    
}

function Add_First_Nozzle($ID)
{
	$db = new MyDB();
	$db->busyTimeout(5000);
$db-> exec('PRAGMA journal_mode=wal;');
	$db->querySingle("INSERT INTO Nozzle_WashingMachine (MachineID, Nozzle_No, ProductID,ProductName, ProductPrice, ProductTime) VALUES (
		'$ID', '0','0', 'UNUTULAN PARA','0','0')");

}
function newConfAddress($ID){ 

	$db = new MyDB();
	$db->busyTimeout(5000);
$db-> exec('PRAGMA journal_mode=wal;');
    $Address = $db->querySingle("SELECT MachineID from Nozzle_WashingMachine where ID ==$ID");
    return $Address;
    
}

function newConf_Save($Address) {  
 $db = new MyDB();
 $db->busyTimeout(5000);
$db-> exec('PRAGMA journal_mode=wal;');
    $db->querySingle("UPDATE WashingMachine set hasNewConf='1' WHERE Address=$Address");
    
}

function updateBarcode($Address,$Port) {  
	$db = new MyDB();
	   $db->querySingle("UPDATE BarcodeScanner set PortNo='$Port' WHERE Address='$Address'");
	   
   }

   function deleteBarcode($Address) {  
	$db = new MyDB();
	$db->busyTimeout(5000);
$db-> exec('PRAGMA journal_mode=wal;');
	$result=$db->query("SELECT Count(*) From BarcodeScanner WHERE Address=$Address");
	$data = $result->fetchArray();
	if($data['Count(*)']>0)
	{
		$db->querySingle("DELETE From BarcodeScanner WHERE Address=$Address");
	}
	   
   }

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

function GetInterfacesAddress(){

		$dosyaismi="/etc/network/interfaces";
        $okunan=file($dosyaismi);
        $dosya= fopen($dosyaismi, 'r');
		$Ip_Address="";
		
		foreach($okunan as $sira => $satir)
        {
		 
			
			  if(strstr($satir, "address")) {
			 
			 $satir = explode(' ', $satir);
			 $IP_Address=$satir[1];
			 
            
			 }
			  
		}
		
	   
	   return $IP_Address;
}

function CheckInterfaces(){

        $dosyaismi="/etc/network/interfaces";
        $okunan=file($dosyaismi);
		$dosya= fopen('/etc/network/interfaces', 'r');	
		$durum=false;
		foreach($okunan as $sira => $satir)
		{
		   if(strstr($satir, "static") && strstr($satir, "#iface")) {    
					$durum=true;  				  
               }       
        }
	fclose($dosya);
	return $durum;

}
  
function SetInterfacesStatic($Address, $Gateway, $SubnetMask){

		$dosyaismi="/etc/network/interfaces";
        $okunan=file($dosyaismi);
        $checked= CheckInterfaces();
        $dosya= fopen($dosyaismi, 'w');
	    var_dump($checked); 	
		
		if($checked==true)
		{
		foreach($okunan as $sira => $satir)
        {
		   if(strstr($satir, "dhcp")) {
			   
			$satir = explode(' ', $satir);
			$replaced = array_search('iface', $satir);
			$satir[$replaced] = '#iface';
			$satir=implode(" ",$satir);
			$okunan[$sira]=$satir;
			}
			 if(strstr($satir, "static")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('iface', $satir);
			 $satir[$replaced] = 'iface';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir;
			 }
			  if(strstr($satir, "address")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('address', $satir);
			 $satir[$replaced+1] = $Address;
			 $satir[$replaced] = 'address';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir."\n";
            
			 }
			  if(strstr($satir, "netmask")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('netmask', $satir);
			 $satir[$replaced+1] = $SubnetMask;
			 $satir[$replaced] = 'netmask';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir."\n";
			 }
			  if(strstr($satir, "gateway")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('gateway', $satir);
			 $satir[$replaced+1] = $Gateway;
			 $satir[$replaced] = 'gateway';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir."\n";
			 }
		}
		}
	   
	   foreach ($okunan as $line_num => $line) {
		   $value="$line";
		$blah = fwrite($dosya,$value);
		}
		fclose($dosya);
}

function UpdateInterfacesStatic($Address, $Gateway, $SubnetMask){

		$dosyaismi="/etc/network/interfaces";
        $okunan=file($dosyaismi);
        $dosya= fopen($dosyaismi, 'w');
		
		
		foreach($okunan as $sira => $satir)
        {
		   if(strstr($satir, "dhcp")) {
			   
			$satir = explode(' ', $satir);
			$replaced = array_search('iface', $satir);
			$satir[$replaced] = '#iface';
			$satir=implode(" ",$satir);
			$okunan[$sira]=$satir;
			}
			 if(strstr($satir, "static")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('iface', $satir);
			 $satir[$replaced] = 'iface';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir;
			 }
			  if(strstr($satir, "address")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('address', $satir);
			 $satir[$replaced+1] = $Address;
			 $satir[$replaced] = 'address';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir."\n";
            
			 }
			  if(strstr($satir, "netmask")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('netmask', $satir);
			 $satir[$replaced+1] = $SubnetMask;
			 $satir[$replaced] = 'netmask';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir."\n";
			 }
			  if(strstr($satir, "gateway")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('gateway', $satir);
			 $satir[$replaced+1] = $Gateway;
			 $satir[$replaced] = 'gateway';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir."\n";
			 }
		}
		
	   
	   foreach ($okunan as $line_num => $line) {
		   $value="$line";
		$blah = fwrite($dosya,$value);
		}
		fclose($dosya);
}

function SetInterfacesDHCP() {

       $dosyaismi="/etc/network/interfaces";
        $okunan=file($dosyaismi);
        $checked= CheckInterfaces();
	    var_dump($checked); 	
		$dosya= fopen($dosyaismi, 'w');
		if($checked==false)
		{
		foreach($okunan as $sira => $satir)
        {
		   if(strstr($satir, "dhcp") && strstr($satir, "eth0")) {
			   
			$satir = explode(' ', $satir);
			$satir[0] = 'iface';
			$satir=implode(" ",$satir);
			$okunan[$sira]=$satir;
			}
			 if(strstr($satir, "static")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('iface', $satir);
			 $satir[$replaced] = '#iface';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir;
			 }
			  if(strstr($satir, "address")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('address', $satir);
			 $satir[$replaced] = '#address';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir;
			 }
			  if(strstr($satir, "netmask")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('netmask', $satir);
			 $satir[$replaced] = '#netmask';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir;
			 }
			  if(strstr($satir, "gateway")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('gateway', $satir);
			 $satir[$replaced] = '#gateway';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir;
			 }
		}
		}
	   
	   foreach ($okunan as $line_num => $line) {
		   $value="$line";
		$blah = fwrite($dosya,$value);
		}
		fclose($dosya);
}

function GetInterfacesStatic() {
    $dosyaismi="/etc/network/interfaces";
        $okunan=file($dosyaismi);
	  //  var_dump($checked); 	
		$dosya= fopen($dosyaismi, 'r');
		
		foreach($okunan as $sira => $satir)
        {
		  
			 if(strstr($satir, "static")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('iface', $satir);
			 $satir[$replaced] = '#iface';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir;
			 }
			  if(strstr($satir, "address")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('address', $satir);
			 $satir[$replaced] = '#address';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir;
			 }
			  if(strstr($satir, "netmask")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('netmask', $satir);
			 $satir[$replaced] = '#netmask';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir;
			 }
			  if(strstr($satir, "gateway")) {
			 
			 $satir = explode(' ', $satir);
			 $replaced = array_search('gateway', $satir);
			 $satir[$replaced] = '#gateway';
			 $satir=implode(" ",$satir);
			 $okunan[$sira]=$satir;
			 }
		}
}

function setProductNo($Address)
{
  $db = new MyDB();
		$nozzleNumber='';
		$query = "Select Count(*) from Nozzle_WashingMachine Where MachineID=$Address"; 
		$result = $db->query($query);
		while($row = $result->fetchArray()) {
			$nozzleNumber = $row['Count(*)']-1;
		}
		
		
function setAddress()
{
	$output = shell_exec('reboot');
	echo "<pre>$output</pre>";
	
}
 
 $db->querySingle("UPDATE WashingMachine set ProductNo='$nozzleNumber' WHERE Address=$Address");
}
    if($_GET['islem']=="address_check" && !empty($_GET['islem']=="address_check")){
   
     $Address=$_POST['Address'];
     $count = $db->querySingle("Select Count(*) FROM  WashingMachine WHERE Address=$Address");
     
     if($count==0 && $Address!=0)
     {
         $veri=0;
           	echo $veri;
     }
    else
    {
        $veri =1;
        echo $veri;
    }
}

    if($_GET['islem']=="update_machine" && !empty($_GET['islem']=="update_machine")){
         
          $JSON_Data=$_POST['deger'];
          $data=json_decode($JSON_Data);
          $ID = $data->ID;
          $Address =$data->Address;
          $Port = $data->Port;
         // $ProductNo = $data->ProductNo;
          $RepeatCount = $data->RepeatCount;
          $WakeUpCount = $data->WakeUpCount;
          $Status = $data->Status;
     
         
         $query = "UPDATE WashingMachine set Address='$Address', Port='$Port', Status='$Status', RepeatCount='$RepeatCount', WakeUpCount='$WakeUpCount', RepeatCount='$RepeatCount' WHERE ID=$ID";
	
		if ($db->exec($query)) 
        {      
			$count = $db->querySingle("Select Count(*) FROM  Nozzle_WashingMachine WHERE MachineID=$Address");
			if($count>0){
				
			newConf_Save($Address);
			updateBarcode($Address,$Port); 
			}
           
           echo $dil["updateMachine"];
			

        }
        else//ekleme hata
        {
		   
           echo $dil["operationError"];
			
        }    
}

 

    if($_GET['islem']=="machine_save" && !empty($_GET['islem']=="machine_save")){
         
              $JSON_Data=$_POST['deger'];
          $data=json_decode($JSON_Data);
          $Address =$data->Address;
          $Port = $data->Port;
         $ProductNo ="0";
          $RepeatCount = $data->RepeatCount;
          $WakeUpCount = $data->WakeUpCount;
          $Date = $data->Date;
          $Time = $data->Time;
          $Status = $data->Status;
        $hasNewConf = 0;
       $query = "INSERT INTO WashingMachine (Address, Port,ProductNo,RepeatCount, WakeUpCount, Status, Date, Time, hasNewConf) VALUES (
'$Address', '$Port','$ProductNo','$RepeatCount','$WakeUpCount','$Status','$Date','$Time','$hasNewConf')";

        $count = $db->querySingle("SELECT Count(*) from WashingMachine where Address ==$Address");
if($count>0)
{
      $veri=0;
           	echo $veri;
   
}   
else
{if ($db->exec($query)) 
        {            
			    Add_First_Nozzle($Address);
           		echo $dil["insertMachine"];
        }
        else//ekleme hata
        {
		   echo $dil["operationError"];
			
        }    
}
    }
  
    if($_GET['islem']=="controller_add" && !empty($_GET['islem']=="controller_add")){
         
          $JSON_Data=$_POST['deger'];
          $data=json_decode($JSON_Data);
          $IP_type = $data->IP_type;
        if($IP_type=='static'){
          $ID =$data->ID;
          $Local_IP =$data->Local_IP;
          $Controller_Gateway = $data->Controller_Gateway;
          $Controller_SubnetMask = $data->Controller_SubnetMask;
          $App_Port = $data->App_Port;
		  $App_URL = $data->App_URL;
		  $App_Username = $data->App_Username;
          $App_Password = $data->App_Password;
          $Controller_Status = $data->Controller_Status;
          $EncryptedCommunication = 1;
          $MacAddress = getMacAddress();
          $Version = "1.0.0";

         $query = "INSERT INTO Controller (ID,Local_IP, MacAddress, Version, ERP_PortNo, Status, ApplicationURL ,ApplicationUserName,ApplicationUserPassword, EncryptedCommunication) VALUES ('$ID','$Local_IP','$MacAddress','$Version','$App_Port','$Controller_Status','$App_URL','$App_Username','$App_Password','$EncryptedCommunication')";
	
		   if ($db->exec($query)) 
          {            
              
              SetInterfacesStatic($Local_IP,$Controller_Gateway,$Controller_SubnetMask);
           
		  echo $dil["insertMessage"];
		  }
          else
          {
		    echo "Static - ".$dil["operationError"];
			
		   	
          }    
     }
        else
        {        
         $ID =$data->ID;
          $Local_IP =$data->Local_IP;
          $App_Port = $data->App_Port;
          $App_URL = $data->App_URL;
          $Controller_Status = $data->Controller_Status;
          $MacAddress = getMacAddress();
		    $EncryptedCommunication = 1;
          $Version = "1.0.0";

		
         
         $query = "INSERT INTO Controller (ID,Local_IP, MacAddress, Version, ERP_PortNo, Status, ApplicationURL, EncryptedCommunication) VALUES ('$ID','$Local_IP','$MacAddress','$Version','$App_Port','$Controller_Status','$App_URL','$EncryptedCommunication')";
	
		if ($db->exec($query)) 
        {            
           
            SetInterfacesDHCP();
            echo $dil["insertMessage"];
        }
        else//ekleme hata
        {
		    echo "DHCP - ".$dil["operationError"];
			
        }  }   
}

    if($_GET['islem']=="controller_update" && !empty($_GET['islem']=="controller_update")){
         
          $JSON_Data=$_POST['deger'];
          $data=json_decode($JSON_Data);
          $IP_type = $data->IP_type;
        if($IP_type=='static'){
          $ID =$data->ID;
          $Local_IP =$data->Local_IP;
          $Controller_Gateway = $data->Controller_Gateway;
          $Controller_SubnetMask = $data->Controller_SubnetMask;
          $App_Port = $data->App_Port;
          $App_URL = $data->App_URL;
          $App_Username = $data->App_Username;
          $App_Password = $data->App_Password;
          $Controller_Status = $data->Controller_Status;
       	  $MacAddress = getMacAddress();
         
         $newURL =$Local_IP;
         $query = "UPDATE Controller set Local_IP='$Local_IP', MacAddress='$MacAddress',ERP_PortNo='$App_Port', Status='$Controller_Status', ApplicationURL='$App_URL',ApplicationUserName='$App_Username', ApplicationUserPassword='$App_Password'  WHERE ID=$ID";

	       var_dump(Local_IP);
		  if ($db->exec($query)) 
          {            
              UpdateInterfacesStatic($Local_IP,$Controller_Gateway,$Controller_SubnetMask);
			  setAddress(); 
			  echo $dil["updateMessage"];
			  
			 
          }
          else//ekleme hata
          {
		    
			echo $dil["operationError"];
		   	
          }    
     }
        else
        {        
          $ID =$data->ID;
          $Local_IP =$data->Local_IP;
          $App_Port = $data->App_Port;
          $App_URL = $data->App_URL;
		   $App_Username = $data->App_Username;
          $App_Password = $data->App_Password;
          $Controller_Status = $data->Controller_Status;
          $MacAddress = getMacAddress();
         
         
        $query = "UPDATE Controller set Local_IP='$Local_IP', MacAddress='$MacAddress',ERP_PortNo='$App_Port', Status='$Controller_Status', ApplicationURL='$App_URL',ApplicationUserName='$App_Username', ApplicationUserPassword='$App_Password'  WHERE ID=$ID";
	
		if ($db->exec($query)) 
        {            
           
            SetInterfacesDHCP();
           	 echo $dil["insertMessage"];
        }
        else//ekleme hata
        {
		   echo "DHCP - ".$dil["operationError"];
			
        } 
        }  
}
if($_GET['islem']=="machine_delete" && !empty($_GET['islem']=="machine_delete")){
        
	$ID=$_POST['MachineID'];
	$veri='';
	$Address = $db->querySingle("SELECT Address from WashingMachine where ID ==$ID");
	$count = $db->querySingle("SELECT Count(*) from Nozzle_WashingMachine where MachineID ==$Address AND Nozzle_No>0");
if($count>0)
{ 
	$veri=0;
echo $veri;
//echo $dil["RegisteredNozzle"];
}
else
{
$query ="DELETE FROM WashingMachine WHERE ID=$ID";

if ($db->exec($query)) 
{     
	deleteBarcode($Address);
	//Unutulan Para Nozzle u için Satış var mı yok mu kontrol edilecek...	
	$db->querySingle("DELETE FROM Nozzle_WashingMachine WHERE MachineID=$Address AND Nozzle_No=0");
	
		echo $dil["deleteMachine"];
}
else
{
		echo $dil["operationError"];
} 
}   
}
    if($_GET['islem']=="nozzle_sil" && !empty($_GET['islem']=="nozzle_sil")){
        
     $NozzleID=$_POST['NozzleID'];
     $MachineID='';
	 $NozzleNo = '';
	  
     $query_nozzle ="Select * FROM  Nozzle_WashingMachine WHERE ID=$NozzleID";
	 $result_nozzles= $db->query($query_nozzle);
	 $result_nozzle = $result_nozzles->fetchArray();
	 
	 $MachineID =$result_nozzle['MachineID'];
	 $NozzleNo =$result_nozzle['Nozzle_No'];
	 
	 $query_sales = "SELECT  Count(*) From SALES INNER JOIN SalesItems on Sales.SaleID = SalesItems.SaleID INNER JOIN Nozzle_WashingMachine on SALES.PeronNo = $MachineID WHERE SalesItems.NozzleNo==$NozzleNo";
	
	 $counts = $db->querySingle($query_sales);
	 $count = $counts / 11;
	 
	
        if($count>0)
        {
			$response=0;
			header('HTTP/1.1 500 Iternal Server Error');
			die( $dil["RegisteredSales"]);
        }
        else
        { 
			$query ="DELETE FROM  Nozzle_WashingMachine WHERE ID=$NozzleID";
			$MachineID=newConfAddress($NozzleID);
			if ($db->exec($query)) {
				newConf_Save($MachineID);
				setProductNo($MachineID);
				
				echo 'Silme Başarılı';
			}
			else//ekleme hata
			{
				die( $dil["operationError"]);
			}
		}
	}

	if($_GET['islem']=="user_ekle" && !empty($_GET['islem']=="user_ekle")){
         

		$JSON_Data=$_POST['deger'];
		$data=json_decode($JSON_Data);
		$Username= $data->Username;
		$Password =$data->Password;
		$count = $db->querySingle("Select Count(*) FROM  users WHERE username=$Username");
		if(count>0)
		{
			echo $dil["operationError"];
		  
		}
		else{

			$query = "INSERT INTO users (username,pass,authority) VALUES ('$Username', '$Password',0)";
			
			if ($db->exec($query)) 
			{ 
				echo $dil["insertMessage"];
				
			}
			else//ekleme hata
			{
				echo $dil["operationError"];
				
			}    
		}
}
if($_GET['islem']=="user_update" && !empty($_GET['islem']=="user_update")){
         

	$JSON_Data=$_POST['deger'];
	$data=json_decode($JSON_Data);
	$Username= $data->Username;
	$Password =$data->Password;
	$ID =$data->ID;

      $query = "UPDATE users  set username='$Username', pass='$Password' WHERE ID=$ID";

		if ($db->exec($query)) 
		{ 
			echo $dil["updateMessage"];
			
		}
		else//ekleme hata
		{
			echo $dil["operationError"];
			
		}    
	
}

if($_GET['islem']=="user_delete" && !empty($_GET['islem']=="user_delete")){
         

	$JSON_Data=$_POST['deger'];
	$data=json_decode($JSON_Data);
	$ID= $data->ID;

	$query ="DELETE FROM users WHERE ID=$ID";

		if ($db->exec($query)) 
		{ 
			echo $dil["deleteMessage"];
			
		}
		else//ekleme hata
		{
			echo $dil["operationError"];
			
		}    
	
}

if($_GET['islem']=="barcode_add" && !empty($_GET['islem']=="barcode_add")){
         

	$JSON_Data=$_POST['deger'];
	$data=json_decode($JSON_Data);
	$Address = $data->Address;
	$MachineNo = $data->MachineNo;
	$Port =$data->Port;
	$Timeout = $data->Timeout;
	$Status = $data->Status;
 $query = "INSERT INTO BarcodeScanner (Address, PortNo, Status ,MachineNo, Timeout, hasNewConf) VALUES (
'$Address', '$Port','$Status', '$MachineNo','$Timeout','0')";

if ($db->exec($query)) 
  { 	 
	  echo $dil["insertMessage"];
  }
  else//ekleme hata
  {
	 echo $dil["operationError"];
  }    
}


if($_GET['islem']=="barcode_update" && !empty($_GET['islem']=="barcode_update")){
         

	$JSON_Data=$_POST['deger'];
	$data=json_decode($JSON_Data);
	$Address = $data->Address;
	$MachineNo = $data->MachineNo;
	$Port =$data->Port;
	$Timeout = $data->Timeout;
	$Status = $data->Status;
 
	$query = "UPDATE BarcodeScanner  set Address='$Address', Status='$Status', Timeout='$Timeout' WHERE MachineNo=$MachineNo";

if ($db->exec($query)) 
  { 	 newConfBarcode($MachineNo);
	  echo $dil["updateMessage"];
  }
  else//ekleme hata
  {
	 echo $dil["operationError"];
  }    
}

if($_GET['islem']=="delete_barcode" && !empty($_GET['islem']=="delete_barcode")){
         

	$JSON_Data=$_POST['deger'];
	$data=json_decode($JSON_Data);
	$MachineNo = $data->MachineNo;
	
 $query = "DELETE FROM BarcodeScanner Where MachineNo='$MachineNo'";

if ($db->exec($query)) 
  { 	 
	  echo $dil["deleteMessage"];
  }
  else//ekleme hata
  {
	 echo $dil["operationError"];
  }    
}

    if($_GET['islem']=="nozzle_ekle" && !empty($_GET['islem']=="nozzle_ekle")){
         

          $JSON_Data=$_POST['deger'];
          $data=json_decode($JSON_Data);
          $MachineID = $data->MachineID;
          $Nozzle_No =$data->Nozzle_No;
          $ProductID = $data->ProductID;
          $ProductName = $data->ProductName;
          $ProductPrice = $data->ProductPrice;
          $ProductTime = $data->ProductTime;
       $query = "INSERT INTO Nozzle_WashingMachine (MachineID, Nozzle_No, ProductName,ProductID, ProductPrice, ProductTime) VALUES (
'$MachineID', '$Nozzle_No','$ProductName', '$ProductID','$ProductPrice','$ProductTime')";

      if ($db->exec($query)) 
        { 
            newConf_Save($MachineID); 
			setProductNo($MachineID);
			echo $dil["insertMessage"];
           
			

        }
        else//ekleme hata
        {
		   echo $dil["operationError"];
			
        }    
}
if($_GET['islem']=="shift_insert" && !empty($_GET['islem']=="shift_insert")){
         

	$JSON_Data=$_POST['deger'];
	$data=json_decode($JSON_Data);
	$Status = $data->Status;
	$date= $data->tarih;
	$time = $data->saat;
	$result=$db->query("SELECT Count(*) From Shifts WHERE ShiftBeginDate='$date'");
	$data = $result->fetchArray();
	$ShiftNo = $data["Count(*)"]+1;

	$dateParts= explode(".",$date);
	$dateNumber = $dateParts[2]."".$dateParts[1]."".$dateParts[0];
	$ShiftName = $dateNumber."/".$ShiftNo;
$query = "INSERT INTO Shifts (ShiftName, ShiftBeginDate, ShiftBegintime, Status) VALUES ('$ShiftName','$date', '$time','$Status')";

if ($db->exec($query)) 
  {            
	 echo $dil["shiftOpenMessage"];

  }
  else//ekleme hata
  {
	  echo $dil["operationError"];
	  
  }    
}

if($_GET['islem']=="shift_update" && !empty($_GET['islem']=="shift_update")){
         

	$JSON_Data=$_POST['deger'];
	$data=json_decode($JSON_Data);
	$Status = $data->Status;
	$date= $data->tarih;
	$time = $data->saat;
	

	$query = "UPDATE Shifts  set ShiftEndDate='$date', ShiftEndTime='$time', Status='$Status' WHERE Status='1'";

if ($db->exec($query)) 
  {            
	 echo $dil["shiftCloseMessage"];

  }
  else//ekleme hata
  {
	  echo $dil["operationError"];
	  
  }    
}
    if($_GET['islem']=="update_nozzle" && !empty($_GET['islem']=="update_nozzle")){
         

          $JSON_Data=$_POST['deger'];
          $data=json_decode($JSON_Data);
          $ID = $data->ID;
          $MachineID = $data->MachineID;
          $Nozzle_No =$data->Nozzle_No;
          $ProductID = $data->ProductID;
          $ProductName = $data->ProductName;
          $ProductPrice = $data->ProductPrice;
          $ProductTime = $data->ProductTime;
       $query = "UPDATE Nozzle_WashingMachine  set MachineID='$MachineID', Nozzle_No='$Nozzle_No', ProductName='$ProductName',ProductID= '$ProductID', ProductPrice='$ProductPrice',ProductTime='$ProductTime' WHERE ID=$ID";
        newConf($ID);
      if ($db->exec($query)) 
        {            
           echo $dil["updateMessage"];

        }
        else//ekleme hata
        {
		    echo $dil["operationError"];
			
        }    
}
    
    if($_GET['islem']=="update_port" && !empty($_GET['islem']=="update_port")){
         

          $JSON_Data=$_POST['deger'];
          $data=json_decode($JSON_Data);
          $ID = $data->ID;
          $Name= $data->Name;
          $Baud =$data->Baud;
          $DataBit = $data->DataBit;
          $Parity = $data->Parity;
       $query = "UPDATE PortSettings  set  Name='$Name', Baud='$Baud',DataBit= '$DataBit', Parity='$Parity' WHERE ID=$ID";

        if ($db->exec($query)) 
        {            
            echo $dil["updateMessage"];
			

        }
        else//ekleme hata
        {
		  echo $dil["operationError"];
			
        }    
}
?>