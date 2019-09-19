<?php

include "ayar.php";

shell_exec('sudo chmod 777 /etc/network/interfaces');
session_start();

    
if (isset($_GET["login"])){


   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      //echo "Opened database successfully\n";
   }

   $sql ='SELECT * from users where username="'.$_POST["username"].'";';

	$ID='';
	$ret = $db->query($sql);
	//$pass_md5=md5($_POST['password'])
   
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      $ID=$row['ID'];
      $username=$row["username"];
      $password=$row['pass'];
      $authority=$row['authority'];
      
	 
  }
    if ($ID!=""){
        if ($password==$_POST["password"]){
           $_SESSION["login"]="true";
           $_SESSION["username"]=$username;
           $_SESSION["admin"] = "false";
           $_SESSION["dil"]="tr";
           $_SESSION["authority"]=$authority;
           header('Location: index.php');    
        }else{
          
          $message = "Wrong Password";
echo "<script type='text/javascript'>alert('$message');</script>";
        }
      }else{
       echo "User not exist, please register to continue!";
      }
   //echo "Operation done successfully\n";
   $db->close();
     }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Giriş</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="images/icon/logo.png" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="login.php?login=true" method="post">
                                <div class="form-group">
                                     <div class="input-group">
                                                    <div class="input-group-addon">Kullanıcı Adı : </div>
                                                    <input type="text" id="username" name="username" class="form-control" autocomplete="off">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                </div>
                                <div class="form-group">
                                   <div class="input-group">
                                                    <div class="input-group-addon">Şifre &ensp;  &ensp;&ensp;&ensp;&ensp;&ensp; :</div>
                                                    <input type="password" id="password" name="password" class="form-control" autocomplete="off">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-asterisk"></i>
                                                    </div>
                                                </div>
                                </div>
                                <div class="login-checkbox">
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" >Gİrİş Yap</button>
								</div>

                              <!--  <label>
                                  <a href="#">Parolamı Unuttum</a>
                                </label> --> 
                              
						   
                        </form>
						</div>  
                           <!-- <div class="register-link">
                                <p>
                                   Kayıtlı hesabınız yok mu?
                                    <a href="#">Üye Ol</a>
                                </p>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
   <script src="vendor/jquery-3.3.1.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>

    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
	 <script src="js/main.js"></script>
	 <script src="js/dataTables.fixedHeader.min.js"></script>
	 <script src="js/jquery.dataTables.min.js"></script>


</body>

</html>
<!-- end document-->