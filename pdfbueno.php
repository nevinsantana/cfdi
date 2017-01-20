<?php

$fname = "56718DCE-BD5B-4BC2-AA1D-284791B144A7.xml";
if(!file_exists($fname)){
 die(PHP_EOL . "File not found" . PHP_EOL . PHP_EOL);
}

$handle = fopen($fname, "r");
$sData = '';
$usuario = "testing@solucionfactible.com";
$password = "a0123456789";
$diseno = 2;
$uuid = "233387";
$serie = "B";

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
        $client = new SoapClient("https://testing.solucionfactible.com/ws/services/CFDI?wsdl");
       /* $params = array('usuario' => $usuario, 'password' => $password, 'cfdiBase64'=>$b64, 'zip'=>False);*/
        $response = $client->__soapCall('generarPDF', array(
            'usuario' => $usuario,
            'password' => $password,
            'diseno' => $diseno,
            'uuid' => $uuid,
            'serie' => $serie
        ));
} catch (SoapFault $fault) {
        echo "SOAPFault: ".$fault->faultcode."-".$fault->faultstring."\n";
}

$ret = $response->return;

print_r("Estatus request: " . $ret->status . PHP_EOL);
print_r("Mensjae request: " . $ret->mensaje . PHP_EOL);
print_r("Nombre: " . $ret->pdf . PHP_EOL);

if($ret->status == 200) {
        print_r("Contenido resultados: " . PHP_EOL);
        print_r($ret->resultados);
}
?>