<?php

#----------------------------------------------
# Dr. R. Urban
# 14.3.2017
#----------------------------------------------
$timestamp = time();
#----------------------------------------------
if(!isset($_POST['action'])) {
echo "keine Daten!"; exit;
}

else {
$action = $_POST['action'];
$name = $_POST['name'];
$name = preg_replace ( '/[^a-z0-9 ]/i', '', $name); #Sonderzeichen entfernen

$message = $_POST['message'];
$message = preg_replace ( '/[^a-z0-9 ]/i', '', $message); #Sonderzeichen entfernen
#Daten lesen

#$message_old = file_get_contents ("data/shout.dat");

#Daten speichern
if($action  === "shout" && $message != "") {



$total_message = "$timestamp%%$name%%$message";

$datei = fopen("data/shout.dat","w+"); 

fwrite($datei, $total_message);
fclose($datei);

}

#----------------------------------------------

#print_r($_POST); 

}

?>
