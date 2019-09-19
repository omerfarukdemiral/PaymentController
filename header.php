<!DOCTYPE>
<html>
<?php
if(!$_SESSION["dil"]){
require("dil/en.php");
}
else{
require("dil/".$_SESSION["dil"].".php");
}
$Local_IP=$_SERVER['SERVER_ADDR'];

include "ayar.php";

$query = "SELECT ID, * FROM Controller";

$result = $db->query($query);
$count = $db->querySingle("SELECT Count(*) from Controller");
$queryShiftCount = "SELECT Count(*) FROM Shifts WHERE Status='1'";
$resultx = $db->query($queryShiftCount);
$data = $resultx->fetchArray();
$shiftStatus =0;
$ShiftDate = "";
$ShiftTime = "";

if($data['Count(*)']>0)
{
$queryShift = "SELECT * From Shifts Where Status='1'";
$resultShifts = $db->query($queryShift);
$data = $resultx->fetchArray();
$ShiftDate = $data['ShiftBeginDate'];
$ShiftTime = $data['ShiftBeginTime'];
$shiftStatus =1;
}
?>

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title><?php echo $_SERVER['SERVER_ADDR']; ?> - WashingConf</title>
  <!-- Jquery JS-->
    <script src="vendor/jquery-3.3.1.js"></script>
    <script src="js/sweetalert-dev.js"></script>
    <script src="js/jquery-clockpicker.min.js"></script>
    

    <!-- Fontfaces CSS-->
	
    <link href="css/sweetalert.css" rel="stylesheet" media="all">
    <link href="css/font-face.css" rel="stylesheet" media="all">
	<link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/jquery-clockpicker.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/fixedHeader.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
    
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
	
	  <!-- Date Range Picker -->
	<link rel="stylesheet" type="text/css" media="all" href="css/buttons.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="css/daterangepicker.css" />
	<link rel="stylesheet" href="css/jquery-ui.css">
   
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.tr.js"></script>  
    <script>  
   
    </script> 
</head>

<body class="">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="./">
                            <img src="images/icon/logo.png" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                      <?php if($count>0){ 
					  while($row = $result->fetchArray()) {
                          
                         if($_SESSION["authority"]==1)
                         {?> 
                         
                        <li>
                            <a href="main.php?ID=<?php echo $row['ID'];?>"> <i class="zmdi zmdi-settings"></i><?php echo $dil["menu0"];?></a>
                        </li>
						
						<li>
                            <a href="machine_list.php?ID=<?php echo $row['ID'];?>">
                                <i class="fa fa-fire-extinguisher"></i><?php echo $dil["menu1"];?></a>
                         </li>
                          <?php
                         }?>
                        <li>
                            <a href="sales_list.php">
                                <i class="fas fa-dollar"></i><?php echo $dil["menu2"];?></a>
                        </li>
						<?php if( $_SESSION["authority"]==1)
                         {?> 
                        <li>
                            <a href="port_list.php">
                                <i class="fas fa-table"></i><?php echo $dil["menu3"];?></a>
                        </li>
                        <li>
                            <a href="shifts.php">
                                <i class="fa fa-retweet"></i><?php echo $dil["menu6"];?></a>
                        </li>
                        <!--<li>
                            <a href="lisans.php">
                            <i class="far fa-check-square"></i><?php echo $dil["licence"];?></a>
                        </li>-->
                        <?php
                         }?>
						
                        <li>
                                 <a href="logout.php"><i class="zmdi zmdi-power"></i><?php echo $dil["menu5"];?></a>
                        </li>
                        <?php if( $_SESSION["authority"]==1)
                         {?> 
                        <li>
                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#mediumModal">
											Admin LOG
										</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="JSalert_reboot()">
                                        Reboot
										</button>
                                        
                        </li>
                        <?php
                         }?>
					  <?php }} ?>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="./">
                    <img src="images/icon/logo.png" alt="Mepsan Admin" />
                </a>
            </div>  
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">         
                    <?php if($count>0){ 
					  while($row = $result->fetchArray()) {
                          
                         if($_SESSION["authority"]==1)
                         {?> 
                         
                        <li>
                            <a href="main.php?ID=<?php echo $row['ID'];?>"> <i class="zmdi zmdi-settings"></i><?php echo $dil["menu0"];?></a>
                        </li>
						
						<li>
                            <a href="machine_list.php?ID=<?php echo $row['ID'];?>">
                                <i class="fa fa-fire-extinguisher"></i><?php echo $dil["menu1"];?></a>
                         </li>
                          <?php
                         }?>
                        <li>
                            <a href="sales_list.php">
                                <i class="fas fa-dollar"></i><?php echo $dil["menu2"];?></a>
                        </li>
						<?php if( $_SESSION["authority"]==1)
                         {?> 
                        <li>
                            <a href="port_list.php">
                                <i class="fas fa-table"></i><?php echo $dil["menu3"];?></a>
                        </li>
                        <li>
                            <a href="shifts.php">
                                <i class="fa fa-retweet"></i><?php echo $dil["menu6"];?></a>
                        </li>
                        <!-- <li>
                            <a href="lisans.php">
                            <i class="far fa-check-square"></i><?php echo $dil["licence"];?></a>
                        </li>-->
                        <?php
                         }?>
						
                        <li>
                                 <a href="logout.php"><i class="zmdi zmdi-power"></i><?php echo $dil["menu5"];?></a>
                        </li>
                        
					  <?php }} ?>
                    </ul>
                </nav>
            </div>  <?php if( $_SESSION["authority"]==1)
                         {?> 
            <div class="" style="position: fixed; bottom: 10px; left:20px;">
            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#mediumModal">
                                         Admin LOG
										</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="JSalert_reboot()">
                                        Reboot
										</button>
            </div>
            <?php
                         }?>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                           <div class="content" style="width:100%">          
                                <div class="row">
                                  
                             
                                  <div class="col-12" >
                                <div class="row" style="float:left; margin-left:10px;">       
                                <div class='time-frame'>
                                        <div id='tarih-bolumu' name="tarih"></div>
                                        <div id='saat-bolumu' name="saat"></div>
                                    </div>
                                </div>
                              
                                  <div class="account-wrap">
									<div class="row account-item clearfix js-item-menu" style="float:right; margin-right:15px;margin-top: 10px;">		
                                        <div class="image">
                                            <img src="images/icon/avatar-01.jpg" alt="mepsan"/>
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#"><?php  echo $_SESSION["username"]; ?></a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <a href="./user_profile.php?username=<?php  echo $_SESSION["username"];?>">
                                                <div class="image">
                                                        <img src="images/icon/avatar-01.jpg" alt="mepsan" />
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                    <?php echo $dil["loginusername"];?> <?php  echo $_SESSION["username"]; ?>
                                                    </h5>
                                                    <span class="email"><?php echo $dil["dil"];?> : <?php  echo strtoupper($_SESSION["dil"]); ?></span>

                                                </div></a>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                <a href="dil.php?dil=tr">  <i class="zmdi zmdi-flag"></i>
                                                 <?php echo $dil["trdil"];?> </a> 
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="dil.php?dil=en"> <i class="zmdi zmdi-flag"></i>
                                                    <?php echo $dil["ingdil"];?></a>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="./user_profile.php?username=<?php  echo $_SESSION["username"];?>">
                                                     <i class="zmdi zmdi-assignment-account"></i>
                                                    <?php echo $dil["userprofile"];?></a>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="user_add.php"> <i class="zmdi zmdi-account-add"></i>
                                                    <?php echo $dil["useradd"];?></a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                            <a href="logout.php"><i class="zmdi zmdi-power"></i><?php echo $dil["menu5"];?></a>
                                            </div>
                                        </div>
                                        </div>
                                      
                                    <div id="vardiyaHeader" style="float:right; ">
                                    <button type="button" class="" onclick="JS_Alert_TopBar('<?php echo $shiftStatus;?>');">
                                    <?php if($shiftStatus==1)
                                            {?>
                                    <div class="alert alert-success" role="alert" style="margin-right:20px;">
                                         
                                         <?php echo $dil["shiftOpenStatus"];  ?>
                                           <div hidden id="ShiftDate"></div> 
                                           <div hidden id="ShiftTime"></div> 
										</div>    
                                            <?php }
                                            
                                            
                                           else { ?>
                                    <div  class="alert alert-danger" role="alert" style="margin-right:20px;">
                                         
                                    <?php echo $dil["shiftCloseStatus"];  ?>                                        
                                            
										</div>    
                                            <?php } ?>
                                           </button>	</div>    
                                   
                                    </div>
                                </div>
                                </div>
                             
                                			
                        </div>
                    </div>
                </div>
                </div>
            </header>

            

<script type="text/javascript">

		$(document).ready(function() {
			var interval = setInterval(function() {
				var momentNow = moment();
             
				$('#tarih-bolumu').html(momentNow.format('DD.MM.YYYY'));
				$('#saat-bolumu').html(momentNow.format('HH:mm:ss'));
			}, 100);
		});

</script>
<script type="text/javascript">
 /*function getLocalIP()
    {   
            window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;//compatibility for Firefox and chrome
            var pc = new RTCPeerConnection({iceServers:[]}), noop = function(){};      
            pc.createDataChannel('');//create a bogus data channel
            pc.createOffer(pc.setLocalDescription.bind(pc), noop);// create offer and set local description
            pc.onicecandidate = function(ice)
            {
                if (ice && ice.candidate && ice.candidate.candidate)
                {
                   var LocalIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate)[1];
                    console.log('Local IP: ', LocalIP);
                    document.getElementById("Local_IP").value=LocalIP;
                    pc.onicecandidate = noop;
                    
                }
            };
       
      
    }*/
	
	function JSalert_reboot()
    {
        swal({
  title: "Reboot",
  text: "<?php echo $dil["sure"];?>",
  type: "warning",
  showCancelButton: true,
  cancelButtonText: "<?php echo $dil["no"];?>",
  confirmButtonClass: "btn-danger",
  confirmButtonText: "<?php echo $dil["yes"];?>",
  closeOnConfirm: false
},
function(){
    swal("Reboot!", "", "success");
    window.location.href="reboot.php"
  
  
});
    }
 

function JSalert_Update(){
	swal("<?php echo $dil["updateTitle"];?>", "<?php echo $dil["updateMessage"];?>", "success");
}
function JSalert_Insert(){
	swal("<?php echo $dil["insertTitle"];?>", "<?php echo $dil["insertMessage"];?>");
}

function JSalert_With_Redirect_Update(redirectURL){
	
	swal({ title : "<?php echo $dil["updateTitle"];?>",
							text: "<?php echo $dil["updateMessage"];?>",
							type: "success"
				   },
				   function(){
					   window.location.href=redirectURL;
                   });
                }
                function JS_Alert_TopBar(message){

                     if(message==0)
                     {

                         swal({          
                             title: "<?php echo $dil["shiftCloseStatus"];?>",
                             type: "info"
                            });    
                        }
                        else{
                            JSalert_ShiftStatus();
				   }
                        }
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

function JSalert_With_Redirect_Insert(redirectURL){
	
	swal({ title : "<?php echo $dil["insertTitle"];?>",
							text: "<?php echo $dil["insertMessage"];?>",
							type: "info"
				   },
				   function(){
					   window.location.href=redirectURL;
				   });
				   
	
}
function JSalert_Insert_Message(message){
	
	swal({                  title : message,
							type: "info"
				   });
				   
	
}
function JSalert_With_Redirect_Delete(redirectURL){
	
	swal({ title : "<?php echo $dil["deleteTitle"];?>",
							text: "<?php echo $dil["deleteMessage"];?>",
							type: "info"
				   },
				   function(){
					   window.location.href=redirectURL;
				   });
				   
	
}
function JSalert_With_Redirect_InsertMachine(redirectURL,message){
	
	swal({ title : "<?php echo $dil["insertTitle"];?>",
							text: message,
							type: "info"
				   },
				   function(){
					   window.location.href=redirectURL;
				   });
				   
	
}

function JSalert_NoSale(message){
	
	swal({ title : "<?php echo $dil["warningTitle"];?>",
							text: message,
							type: "info"
				   },
				   function(){
					   window.location.href="index.php";
				   });
				   
	
}
function JSalert_With_Redirect_DeleteMachine(message){
	
	swal({ title : "<?php echo $dil["deleteTitle"];?>",
							text: message,
							type: "info"
				   },
				   function(){
                    location.reload();		
				   });
}

function JSalert_With_Redirect_Update(redirectURL){
	
	swal({ title : "<?php echo $dil["updateTitle"];?>",
							text: "<?php echo $dil["updateMessage"];?>",
							type: "info"
				   },
				   function(){
					   window.location.href=redirectURL;
				   });
}


function JSalert_Delete(){
    swal({ title : "<?php echo $dil["deleteTitle"];?>",
							text: "<?php echo $dil["deleteMessage"];?>",
							type: "success"
				   },
				   function(){
                    location.reload();		
                		   });
}
function JSalert_Warning(){
	swal("<?php echo $dil["warningTitle"];?>", "<?php echo $dil["warningMessage"];?>", "error");
}

function JSalert_Warning_Message(message){
	
	swal({ title : "<?php echo $dil["warningTitle"];?>",
							text: message,
							type: "error"
				   });
}
function JSalert_Message(message){

    swal({ title : "<?php echo $dil["infoTitle"];?>",
							text: message,
							type: "info"
				   });

}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
  </script>
                                
	<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel"><?php echo $dil["loginTitle"]; ?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
                        <form action="" method="post">
                                <div class="form-group">
                                     <div class="input-group">
                                                    <div class="input-group-addon"><?php echo $dil["loginusername"]; ?></div>
                                                    <input type="text" id="logger_username" name="logger_username" class="form-control" autocomplete="off" value="">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                </div>
                                <div class="form-group">
                                   <div class="input-group">
                                                    <div class="input-group-addon"><?php echo $dil["loginpass"]; ?></div>
                                                    <input type="password" id="logger_password" name="logger_password" class="form-control" autocomplete="off">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-asterisk"></i>
                                                    </div>
                                                </div>
                                </div>					   
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" type="" id="adminLogin" name="adminLogin"><?php echo $dil["loginbutton"]; ?></button>
						</div>
                        </form>
					</div>
				</div>
			</div>
            <script>
 $("#adminLogin").on("click", function (event) {
     var username = $('input[name="logger_username"]').val();
                            var pass = $('input[name="logger_password"]').val();
                        
                        if(username =="admin" && pass =="*314159*")
                        { 
                            <?php $_SESSION["admin"]='true'; ?>
                            var redirectURL = "./logger.php";
                            window.location = redirectURL;
                        }
                        else{
                            alert("<?php echo $dil["LoginError"];?>");
                        }
 });
            </script>
