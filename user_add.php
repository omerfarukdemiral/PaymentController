<?php
session_start();

if($_SESSION["login"]=='true'){
 include 'header.php';         

$message = ""; 
include "ayar.php";

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
                                        <strong> <?php echo $dil["useradd"];?> </strong>
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
                                                 <input type="text" id="username" name="username" value="" class="form-control">

                                                </div>
                                                </div>
												<div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["loginpass"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                    <input type="password" id="password" name="password" value="" class="form-control">
                                                </div>
                                                </div>
                                                <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["passconfirm"];?></label>
                                                </div>
												<div class="col col-md-6">
                                                    <input type="password" id="passconfirm" name="passconfirm" value="" class="form-control">
                                                </div>
                                                </div>
                                                </div> 
												
                                            </div>
                                          </div>
                                  
                                    <div class="card-footer">
                                        <button type="submit" name="submit_user"  id="submit_user" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> <?php echo $dil["insert"];?> 
                                        </button>
                                    </div>
                                    </form>
                                </div>                                
                            </div>                     
                        </div>
                        </div>
                    
     <script type="text/javascript">

        $("#submit_user").on("click", function (event) {
	       
        event.preventDefault();
       
        
        var Username = $('input[name="username"]').val();
        var Password = $('input[name="password"]').val();
        var passconfirm = $('input[name="passconfirm"]').val();


      if(Password == passconfirm)
      {

        var JSON_Data = "{"+'"'+"Username"+'"'+":"+'"'+Username+'"'+","+'"'+"Password"+'"'+":"+'"'+Password+'"'+"}";
        $.ajax({
               url: "operation.php?islem=user_ekle",
               type: "POST",
               data: "deger="+JSON_Data,
               success: function (cevap) {
				   JSalert_With_Redirect_Insert("./index.php");
               }
           });
      }
         else{
            JSalert_Warning_Message("<?php echo $dil["passconfirmWarning"];?>");
            }
        });

</script>

<?php include 'footer.php'; }
else
{ 	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>         
