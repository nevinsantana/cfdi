<?php
$fname1 = "20001000000200000192.cer";
if(!file_exists($fname1)){
 die(PHP_EOL . "File not found" . PHP_EOL . PHP_EOL);
}
$fname2 = "20001000000200000192.key";
if(!file_exists($fname2)){
 die(PHP_EOL . "File not found" . PHP_EOL . PHP_EOL);
}

$clave = "12345678a";
$handle1 = fopen($fname1, "r");
$handle2 = fopen($fname2, "r");
$sData1 = '';
$sData2 = '';
$usuario = "testing@solucionfactible.com";
$password = "a0123456789";


while(!feof($handle1))
    $sData1 .= fread($handle1, filesize($fname1));
fclose($handle1);
$b641 = base64_encode($sData1);

while(!feof($handle2))
    $sData2 .= fread($handle2, filesize($fname2));
fclose($handle2);
$b642 = base64_encode($sData2);

$detalleCFDI = array(
        'concepto' => 'silla',
        'unidad' => 'pieza',
        'cantidad' => '100',
        'precioUnitario' => 1000,
        'tasaIva' => 15,
        'comment' => 'comentario',
        'importe' => 101500
    );

$comprobantes = array(
    'nombreCliente' => 'NEVIN',
    'rfcCliente' => 'SAEN931101222',
    'fechaPago' => '2017-01-19',
    'autorizada' => true,
    'cancelada' => false,
    'formaPago' => 'EFECTIVO',
    'folio' => 00003,
    'nombreSerie' => 'E',
    'detalleCFDI' => $detalleCFDI
);

$response = '';
/*
Porfavor note:
    Este ejemplo está basado en el WSDL De timbrado
    cada WSDL tiene su propia estructura y deberá modificarse la petición
    acorde al webservice que se esté conectando.*/
try {
        $client = new SoapClient("https://testing.solucionfactible.com/ws/services/CFDI?wsdl");
        $params = array('usuario' => $usuario, 'password' => $password, 'comprobantes'=>$comprobantes, 'zip'=>False);
        $response = $client->__soapCall('crear', array('parameters' => $params));
} catch (SoapFault $fault) {
        echo "SOAPFault: ".$fault->faultcode."-".$fault->faultstring."\n";
}
$ret = $response->return;

print_r("Estatus request: " . $ret->status . PHP_EOL);
print_r("Mensaje request: " . $ret->mensaje . PHP_EOL);
$ret->status = 200;
if($ret->status == 200) {
    print_r("HOLA :v");
        print_r("Contenido resultados: " . PHP_EOL);
        print_r($ret->resultadosCreacion);
}
?>