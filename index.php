<?php
#------------------------------------------------------------------------
# Dr. R. Urban
# 17.3.2017
#------------------------------------------------------------------------
$timestamp = time();

if (!file_exists("data/shout.dat")) {	
$total_message = "$timestamp%% %% ";
$file = fopen("data/shout.dat", "w+"); 
 fwrite($file,$total_message); 
fclose($file);          
} 
#------------------------------------------------------------------------

?>


<!DOCTYPE html>
<html lang="en">
<head>
 <title>Mini Ajax Chat</title>

 
<meta charset="utf-8">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<style>

#box {
	
	 border: 1px solid grey; 
 background-color: white;
//  border-radius: 25px;
    width: 450px;
    height: 200px;
    overflow: scroll;
 padding: 20px; 
}
#hideme {display: none;}
body {background-color: lightgrey;}

</style>

 


 <script>
var init = function() {	
//------------------------------------------------------------------------
// Daten holen

var msg_time_old = 0;
var cumulative_msg = "";
var msg_data = "";


    var i = 5;
document.getElementById('data_2').innerHTML =  i;

//------------------------------------------------------------------------
    var myCall = setInterval(function(){     
 var d = new Date();
    var n = d.toLocaleTimeString();

 $.post("call.php",
    {
         action: "call"
        
    },
    function(data, status){
    	
    	 var msg = data.split("%%");
    
   var msg_time = msg[0];
     var msg_name = msg[1];
       var msg_msg = msg[2]; 
      
if (msg_time_old === 0) 
{
	msg_time_old = msg_time 
     msg_data = n + ' <span class="glyphicon glyphicon-user"></span> ' + msg_name + " schreibt "  + msg_msg + "<br>";
   cumulative_msg += msg_data;
    sound();
}     
//------------------------------------------------------------------------
if (msg_time_old != msg_time ) {
	
  msg_data = n + ' <span class="glyphicon glyphicon-user"></span> ' + msg_name + " schreibt "  + msg_msg + "<br>";
  cumulative_msg = msg_data + cumulative_msg;	
	msg_time_old = msg_time;
	 sound();
		
	}   
      

	
 document.getElementById('data').innerHTML = cumulative_msg;	
       
       
    });

    }, 1000);  
 
//------------------------------------------------------------------------
// Hier werden die Daten gespeichert
     
   $('#shoutbox').on('click', function() {   

  
     var name = $("#name").val();
	  var message = $("#message").val();
	
 
 
    $.post("save.php",
    {
        action: "shout",
        name: name,
        message: message
    },
    function(data, status){
    	 
 	
document.getElementById('data').innerHTML = data;    	
    	document.getElementById("button").disabled = true;	
    	
  
  
    });
    
// Botton kurzfristig deaktivieren  	
  
   var myBotton = setInterval(function(){        
    i--;  
       	document.getElementById('data_2').innerHTML =  i;
       	      	
       	if (i <= 0) {
       		 	document.getElementById("button").disabled = false;	
       		 	i = 5;
       		 	
       		 	clearInterval(myBotton);
       	}
    
    }, 1000);    

  
    
}); 

//------------------------------------------------------------------------

function sound(){

	document.getElementById('sound').innerHTML = '<audio autoplay preload controls> <source src="sound/chat.mp3" type="audio/mp3" /> </audio>';
}
//------------------------------------------------------------------------
 }; // end init()
 $(document).ready(init);
</script> 



<body>

 <div class="container">
  

  <h1>Mini Ajax Chat</h1>
<h2>You are viewing the Demo of Mini AJAX Chat -</h2>
<h3>This is the Simple Chat ;), a simple AJAX chat application written in PHP and Javascript with jQuery and Bootstrap.</h3>


<div id="box"> 
<span id="data"></span>
</div>  
 <br>
<br>
 <textarea name="message" maxlength="100" cols="50" rows="2" placeholder="Message" id="message" onclick="this.value=''"></textarea><br>
<br>
<input type="text" name="name" maxlength="20" placeholder="Name" id="name"><br><br>

<div id="shoutbox"> 
 <button type="button" id="button"   class="btn btn-default"> <span class="badge"><span id="data_2"></span>  </span> Mitteilung senden</button>
  </div>   
     
  </div>   
    
 <div id="hideme">
 <span id="sound"></span>
</div>
</body>
</html>
