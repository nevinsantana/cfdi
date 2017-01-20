<?php
    //ruta al archivo XML del CFDI
    $xmlFile="SAT/ejemplo1cfdv3.xml";

    // Ruta al archivo XSLT
    $xslFile = "SAT/cadenaoriginal_3_0.xslt";

    // Crear un objeto DOMDocument para cargar el CFDI
    $xml = new DOMDocument("1.0","UTF-8");
    // Cargar el CFDI
    $xml->load($xmlFile);

    // Crear un objeto DOMDocument para cargar el archivo de transformación XSLT
    $xsl = new DOMDocument();
    $xsl->load($xslFile);

    // Crear el procesador XSLT que nos generará la cadena original con base en las reglas descritas en el XSLT
    $proc = new XSLTProcessor;
    // Cargar las reglas de transformación desde el archivo XSLT.
    $proc->importStyleSheet($xsl);
    // Generar la cadena original y asignarla a una variable
    $cadenaOriginal = $proc->transformToXML($xml);

    echo $cadenaOriginal;
    ?>