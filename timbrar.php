<?php

$fname = "a.xml";
if(!file_exists($fname)){
 die(PHP_EOL . "File not found" . PHP_EOL . PHP_EOL);
}

$handle = fopen($fname, "r");
$sData = '';
$usuario = "testing@solucionfactible.com";
$password = "timbrado.SF.16672";

while(!feof($handle))
    $sData .= fread($handle, filesize($fname));
fclose($handle);
$b64 = base64_encode($sData);

$response = '';
/*
Porfavor note:
    Este ejemplo está basado en el WSDL De timbrado
    cada WSDL tiene su propia estructura y deberá modificarse la petición
    acorde al webservice que se esté conectando.*/
try {
        $client = new SoapClient("https://testing.solucionfactible.com/ws/services/Timbrado?wsdl");
        $params = array('usuario' => $usuario, 'password' => $password, 'cfdiBase64'=>$b64, 'zip'=>False);
        $response = $client->__soapCall('timbrarBase64', array('parameters' => $params));
} catch (SoapFault $fault) {
        echo "SOAPFault: ".$fault->faultcode."-".$fault->faultstring."\n";
}

$ret = $response->return;

/*print_r("Estatus request: " . $ret->status . PHP_EOL);
print_r("<br><br>Mensjae request: " . $ret->mensaje . PHP_EOL);*/

if($ret->status == 200) {

        print_r("<strong>cadenaOriginal: </strong>".$ret->resultados->cadenaOriginal."<br><br>");
        print_r("<strong>certificadoSAT: </strong>".$ret->resultados->certificadoSAT."<br><br>");
        print_r("<strong>qrCode: </strong>".$ret->resultados->qrCode."<br><br>");
        print_r("<strong>selloSAT: </strong>".$ret->resultados->selloSAT);
}
?>