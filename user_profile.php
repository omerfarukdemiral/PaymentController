<?php
session_start();

if($_SESSION["login"]=='true'){
 include 'header.php';         

$message = ""; 
include "ayar.php";
$db-> exec('PRAGMA journal_mode=wal;');

$Username = $_GET['username']; 
$ID = $db->querySingle("Select ID FROM  users WHERE username='$Username'");
$query = "Select * From users Where ID='$ID'"; 
$result = $db->query($query);

$data = $result->fetchArray();
?>

	<!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                      <div class="container-fluid">

                   <div class="row">                            
							 <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <strong> <?php echo $dil["userprofile"];?> </strong>
                                    </div>
                                      <form  method="POST" class="form-horizontal" action="" >
                                      
                                    <div class="card-body card-block">
                                       <div class="row">
                                            <div class="col-lg-12">
                                            <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["loginusername"];?> </label>
                                                </div>
												 <div class="col col-md-6">
                                                 <input disabled type="text" id="username" name="username" value="<?php echo $data['username'];?>" class="form-control">

                                                </div>
                                                </div>
												<div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["loginpass"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                    <input type="text" id="password" name="password" value="<?php echo $data['pass'];?>" class="form-control">
                                                </div>
                                                </div>
                                                <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["passconfirm"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                    <input type="text" id="passconfirm" name="passconfirm" value="<?php echo $data['pass'];?>" class="form-control">
                                                </div>
                                                </div>
                                                </div> 
												
                                            </div>
                                          </div>
                                  
                                    <div class="card-footer">
                                    <input hidden value="<?php echo $data['ID'];?>" id="ID" name="ID">
                                        <button type="submit" name="update_user"  id="update_user" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> <?php echo $dil["update"];?> 
                                        </button>
                                        <button type="submit" name="delete_user"  id="delete_user" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> <?php echo $dil["delete"];?> 
                                        </button>
                                    </div>
                                    </form>
                                </div>                                
                            </div>                     
                        </div>
                        </div>
                    
     <script type="text/javascript">

        $("#update_user").on("click", function (event) {
	       
        event.preventDefault();
       
        
        var Username = $('input[name="username"]').val();
        var Password = $('input[name="password"]').val();
        var ID = $('input[name="ID"]').val();
        var passconfirm = $('input[name="passconfirm"]').val();


      if(Password == passconfirm)
      {

        var JSON_Data = "{"+'"'+"Username"+'"'+":"+'"'+Username+'"'+","+'"'+"Password"+'"'+":"+'"'+Password+'"'+","+'"'+"ID"+'"'+":"+'"'+ID+'"'+"}";
       
        $.ajax({
               url: "operation.php?islem=user_update",
               type: "POST",
               data: "deger="+JSON_Data,
               success: function (cevap) {
                   
                JSalert_With_Redirect_Update("./index.php");
               }
           });
      }
         else{
            JSalert_Warning_Message("<?php echo $dil["passconfirmWarning"];?>");
            document.getElementById("password").focus();

            }
        });

        $("#delete_user").on("click", function (event) {
	       
           event.preventDefault();
    

           var ID = $('input[name="ID"]').val();
      
           var JSON_Data = "{"+'"'+"ID"+'"'+":"+'"'+ID+'"'+"}";
          
           $.ajax({
                  url: "operation.php?islem=user_delete",
                  type: "POST",
                  data: "deger="+JSON_Data,
                  success: function (cevap) {
                      
                    JSalert_With_Redirect_Delete("./logout.php");
                  }
              });
   
               
           });

</script>

<?php include 'footer.php'; }
else
{ 	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>         
