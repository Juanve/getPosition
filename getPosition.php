<?php
/* This code gets current position of a plate from C2LS tracking system */
require_once('lib/nusoap.php');

// Get parameters
$plate = escapeshellcmd($_GET['plate']);
$company = escapeshellcmd($_GET['company']);
$user = escapeshellcmd($_GET['user']);
$pass = escapeshellcmd($_GET['pass']);

$ns = "http://tempuri.org/";
$oSoapClient = new nusoap_client('http://www.c2ls.co/c2lsservices/position.wsdl', true); 

$parametros = array(); 
$parametros = array('plate'  => $plate); 

$headers = '<AuthCredentials xmlns="http://tempuri.org/">';
$headers .= " <strCompany>$company</strCompany>";
$headers .= " <strUserName>$user</strUserName>";
$headers .= " <strPassword>$pass</strPassword>";
$headers .= "</AuthCredentials>";

$oSoapClient->setHeaders($headers);

$respuesta = $oSoapClient->call("getCurrentPosition", $parametros); 
if ($oSoapClient->fault) { // Si 
        echo 'No se pudo completar la operación '.$oSoapClient->getError(); 
        die(); 
} else { // No 
        $sError = $oSoapClient->getError(); 
       if ($sError) {  
                echo 'Error!:'.$sError; 
        } 
} 
echo '<br>'; 
echo '<pre>'; 
print_r( $respuesta ); 
echo '</pre>';  
?>
