<?php
session_start();
if(!$_SESSION["dil"]){
require("dil/en.php");
}
else{
require("dil/".$_SESSION["dil"].".php");
}
if($_SESSION["login"]=='true' && $_SESSION["authority"]==1){
include 'header.php';

?>  
<script type="text/javascript">
var lines;
var peronList = new Array();
function peronCreate(perons)
{

    perons.forEach(myFunction);

function myFunction(item, index) {
    peronSelect = document.getElementById('peronNo');
    peronSelect.options[peronSelect.options.length] = new Option(item);
}
}
function peronConvertArray(perons)
{

    perons.forEach(myFunction);

function myFunction(item, index) {
    peronList.push(parseInt(item, 10));
}
peronList.sort();
return peronList;
}
window.onload = function() {
    $(document).ready(function() {
        var lang = "<?php echo $dil["lang"];?>";
         if(lang =='tr')
         {
        $("#LogDate").datepicker({
            monthNames: [ "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık" ],
                monthNamesShort: [ "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık" ],
                dayNamesMin: [ "Pa", "Pt", "Sl", "Ça", "Pe", "Cu", "Ct" ],
                firstDay:1,
				changeMonth: true, 
				changeYear: true, 
				dateFormat: "dd.mm.yy",
				});
            }
            else
            {
        $("#LogDate").datepicker({
				changeMonth: true, 
				changeYear: true, 
				dateFormat: "dd.mm.yy",
				});
            }

    jQuery.get('logger.txt', function(data) {
   
//alert(data);
lines = data.split("\n");
var peron = new Array();
var index = 0;

$.each(lines, function(n, elem) {

   if(elem.includes(">>")){
    var elems = elem.split(">>");
    if(elems[0].includes(" ")){   
   var perons = elems[0].split(" ");
   if(perons[2].includes("ToPeron_")){
   peron[index]=  perons[2].replace("ToPeron_","");
  index = index+1;
   }}}
});
var PeronCount = new Set(peron);
var perons = peronConvertArray(PeronCount);


peronCreate(perons);
document.getElementById("loadInfo").innerHTML = "Ready!";

});

var StawizLog = new Array();
var WashingLog = new Array();
    var WashingMachinesLog ;
    var StawizInfo ;
    var Stat ;
$('#loggerType').change(function(){
    
    document.getElementById("loadInfo").innerHTML = "Loading..";
 
if(this.value==0)
{
    document.getElementById("myContainer").innerHTML = "";
}
else if (this.value ==1)
 {  stat=1;    
     
    document.getElementById("logTime").disabled = false;
    document.getElementById("LogDate").disabled = false;
    document.getElementById("peronNo").disabled = true;

    var index = 0;
    var str ='';

    $.each(lines, function(n, elem) {
    var str ='';
      var stat1 = elem.includes("SendToService");
      //alert(elem);
     // alert(stat);
      if(stat1)
      {
       $('#myContainer').append('<div ><pre><code>'+index +" --- "+ elem+'</code></pre>');      
       str=elem;
      }
      var stat2 = elem.includes("FromService");
      if(stat2)
      {
       $('#myContainer').append('<pre><code style="color:blue;">'+elem +'</code></pre></div>');
       str = str+" "+elem;
       StawizLog[index] = str;
       str = '';
       index = index+1;
      }
      var stat3 = elem.includes("DispBlock"); 
      if(stat3)
      {
       $('#myContainer').append('<code style="color:red;">'+elem +'</code></div>');
       str = str+" "+elem;
       StawizLog[index] = str;
       str = '';
       index = index+1;
      }
        });
      document.getElementById("loadInfo").style.visibility = "hidden";
                      
}
else if(this.value ==2)
{   var index = 0;
    stat =2;
    document.getElementById("loadInfo").style.visibility = "visible";
    document.getElementById("loadInfo").innerHTML = "Select Peron..";
    document.getElementById("myContainer").innerHTML = "";

    $.each(lines, function(n, elem) {   
      if(elem.includes("ToPeron")) {
        if(index%2==0)
                        {
                            $('#myContainer').append('<div>'+index +" --- "+ elem+ '</div>');
                        }
                        else
                      $('#myContainer').append('<div  style="color:red;">'+index +" --- "+ elem+ '</div>');
       WashingLog[index] = elem;         
       index = index+1;
      }
  });
  document.getElementById("peronNo").disabled = false;
  document.getElementById("peronNo").focus();
                    //  document.getElementById("loadInfo").style.visibility = "hidden";
}
else if(this.value ==3)
{   var index = 0;
    stat =2;
    document.getElementById("loadInfo").style.visibility = "visible";
    document.getElementById("loadInfo").innerHTML = "Select Peron..";
    document.getElementById("myContainer").innerHTML = "";

    $.each(lines, function(n, elem) {   
      if(elem!="")
      {
        if(index%2==0){
              $('#myContainer').append('<div>'+index +" --- "+ elem+ '</div>');
              }
               else
            $('#myContainer').append('<div  style="color:red;">'+index +" --- "+ elem+ '</div>');
       WashingLog[index] = elem;         
       index = index+1;
            }
    });
  document.getElementById("peronNo").disabled = false;
  document.getElementById("peronNo").focus();
                    //  document.getElementById("loadInfo").style.visibility = "hidden";
}
              });
              var peronNo;
              var logTimes ="00.00.00";
              var LogDate;
              $('#peronNo').change(function(){
                document.getElementById("loadInfo").innerHTML = "Loading..";
                document.getElementById("LogDate").value="01.01.2019";
                document.getElementById("LogDate").disabled = false;
                document.getElementById("myContainer").innerHTML = "";

                  peronNo = this.value;
                  var index =0;
                  $.each(WashingLog, function(n, elem) {
                    if(elem.includes("ToPeron_"+peronNo)){
                        if(index%2==0)
                        {
                            $('#myContainer').append('<div>'+index +" --- "+ elem+ '</div>');
                        }
                        else
                      $('#myContainer').append('<div  style="color:red;">'+index +" --- "+ elem+ '</div>');
                        index = index+1;
                    }
                     document.getElementById("loadInfo").style.visibility = "hidden";
                  });
              });
              $('#logTime').change(function(){
               
                  logTimes = this.value;    
                  document.getElementById("getData").disabled = false;
        
             });
             $('#LogDate').change(function(){
                document.getElementById("logTime").value="00:00:00";

                LogDate = this.value;
                document.getElementById("logTime").disabled = false;
                document.getElementById("getData").disabled = false;

          });
        
  document.getElementById("getData").addEventListener("click", function(event){
                event.preventDefault();
                if(stat==2)
                {   
                document.getElementById("loadInfo").innerHTML = "Loading..";
                document.getElementById("myContainer").innerHTML = "";
                var index = 0 ;
             
            if(logTimes=="00.00.00")
            {
                  $.each(WashingLog, function(n, elem) {
                    if(elem.includes("ToPeron_"+peronNo)){
                            if(elem.includes(LogDate)){
                                if(index%2==0)
                        {
                            $('#myContainer').append('<div>'+index +" --- "+ elem+ '</div>');
                        }
                        else
                      $('#myContainer').append('<div  style="color:red;">'+index +" --- "+ elem+ '</div>');
                        index = index+1;
                       }  
                   
                 }
                });
            }
            else
                {
                  $.each(WashingLog, function(n, elem) {
                    if(elem.includes("ToPeron_"+peronNo)){
                        if(elem.includes(logTimes)){
                            if(elem.includes(LogDate)){
                                if(index%2==0)
                        {
                            $('#myContainer').append('<div>'+index +" --- "+ elem+ '</div>');
                        }
                        else
                      $('#myContainer').append('<div  style="color:red;">'+index +" --- "+ elem+ '</div>');
                        index = index+1;
                       }  
                    }
                 }
                });
            }
            }
                 else if(stat==1)
                {   
                document.getElementById("loadInfo").innerHTML = "Loading..";
                document.getElementById("myContainer").innerHTML = "";
                var index = 0 ;
                  $.each(StawizLog, function(n, elem) {
                    if(elem.includes(logTimes)){
                        if(elem.includes(LogDate)){
                        if(index%2==0)
                        {
                            $('#myContainer').append('<div>'+LogDate+logTimes+"|"+index +" --- "+ elem+ '</div>');
                        }
                        else
                      $('#myContainer').append('<div  style="color:red;">'+LogDate+logTimes+"|"+index +" --- "+ elem+ '</div>');
                        index = index+1;
                 }}
                  });
              }      
            });
        });
}
 //  console.log(data);
  // document.getElementById("div").innerHTML = data;
   //process text file line by line
//   $('#div').html(data.replace('\n',''));
  // data.forEach(myFunction);*/
</script>	         
	<!-- HEADER DESKTOP-->
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                    <?php if($_SESSION["admin"]=='true'){?>
                    <div class="row">  
							 <div class="col-lg-12">
                                <div class="card" style="position:static;">
                                    <div class="card-header">
                                        Log <strong> <?php echo $dil["filter"];?> </strong>
                                        
									</div>
                                      <form  method="POST" class="form-horizontal" action="" >
                                      
										<div class="card-body card-block">
                                         <div class="row">
										<div class="col-lg-4">
                                            <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label">Logger Type</label>
                                                </div>
                                                <div class="col col-md-6">
												<select name="loggerType" id="loggerType" class="form-control">
												     <option value="0" selected>Select..</option>
												     <option value="1">Stawiz</option>
												     <option value="2">Washing Machines</option>								
												     <option value="3"><?php echo $dil["All"];?></option>
												</select> 
												</div> 
											</div> 
                                                <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["PeronNo"];?></label>
                                                </div>
                                                <div class="col col-md-6">
												<select name="peronNo" id="peronNo" class="form-control" disabled>
												     <option value="0" selected>Select</option>							
												</select> 
												</div> 
											</div>   
												
										</div>
											<div class="col-lg-4">
                                                <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["saleDate"];?></label>
                                                </div>
                                                <div class="col col-md-6">
												    <div class="input-group">
												   <input type="text" id="LogDate" name="LogDate" class="form-control" autocomplete="off" disabled value="01.01.2019">
                                                </div>
                                                </div>
                                                </div>
                                              
                                              
											<div class="row form-group">
												<div class="col col-md-6">
                                                    <label for="" class=" form-control-label"><?php echo $dil["saleTime"];?></label>
                                                </div>
                                                <div class="col col-md-6">
												    <div class="input-group">
												   <input type="time" id="logTime" name="logTime" class="form-control" autocomplete="off" value="00:00:00" step="1" disabled>
                                                </div>
												</div>

                                            
                                                 
											</div> 
											</div> 
											 
											<div class="col-lg-4">
											    <div class="col col-md-3">
												    <div class="input-group">
                                                    <button  class="btn btn-success btn-md"  style="float:right;" id="getData" name="getData" disabled >Get Log Data</button>                                                 </div>
												</div>
												</div>
												</div>
										</div> 
										</form>
										</div> 
										</div> 
								</div>                         
<h2>Logger Listesi</h2><br> <button  class="btn btn-primary btn-md"  style="float:right;" id="asagi" name="asagi" ><?php echo $dil["scroll_down"];?></button>                                                 </div>

<h3 id="loadInfo">Loading..</h3>
<div id="myContainer"></div>


<?php  } else
{
    echo "Kullanıcı Girişi yapınız.";
}
include 'footer.php'; }
else
{ 	echo  $_SESSION["login"];
	
	echo "Kullanıcı Girişi yapınız.";
	header('Location: login.php');  
}	?>    

<script type="text/javascript">

$('#asagi').click(function(){
        $('html, body').animate({scrollTop:$(document).height()}, 'fast');
        return false;
    });

/*

var lineReader = require('readline').createInterface({
  input: require('fs').createReadStream('logger.txt')
});

lineReader.on('line', function (line) {
  console.log('Line from file:', line);
});*/
</script>				