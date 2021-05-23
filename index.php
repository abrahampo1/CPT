<?php

use Symfony\Component\HttpClient\HttpClient;
?>


<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <title>Transporte Metropolitano Galicia by CP</title>
    <link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>
    * {
        font-family: 'Pattaya', sans-serif;
    }
</style>



<form name="buscaTarxetaForm" id="buscaTarxetaForm" method="post" action="">
    <div class="error"> </div>
    <div style="float:left; vertical-align: middle;">
        <div style="float:left;vertical-align: middle; text-align:center"> <label for="numero"> <strong>Número de Tarxeta:&nbsp;</strong> </label> </div>
        <div style="float:left"> <input type="text" name="numero" maxlength="16" size="20" value="9870200103354001" class=""> </div>
    </div>
    <p> <input type="submit" value="Buscar"></p>
</form>
<?php
if (isset($_POST["numero"])) {
    $hora = time();
    $texto = "";
    require('vendor/autoload.php');
    $url_xunta = "https://tmg.xunta.gal/consulta-de-bonificacions?p_p_id=tarxetaTMG_WAR_tarxetaTMG&p_p_lifecycle=1&p_p_state=normal&p_p_mode=view&p_p_col_id=column-2&p_p_col_count=1&_tarxetaTMG_WAR_tarxetaTMG__spage=%2Fportlet_action%2FtarxetaTMG%2FbuscaTarxeta&_tarxetaTMG_WAR_tarxetaTMG__sorig=%2Fportlet_action%2FtarxetaTMG%2FbuscaTarxeta";

    $httpClient = HttpClient::create();
    $response = $httpClient->request('POST', $url_xunta, [
        'body' => [
            'numero' => $_POST["numero"],
        ]
    ]);
    error_reporting(E_ERROR | E_PARSE);
    $content = $response->getContent();
    $contenido = explode("\n", $content);
    $contenido_descartado = explode("<br>", $contenido[64]);
    //var_dump($contenido_descartado);
    $fila = explode("<p>", $contenido_descartado[1]);
    $err_no_data = "Non hai ningunha recarga";
    if(strstr($contenido_descartado[0], $err_no_data)){
        echo "<p class='error'>Esta tarjetiña no tiene datos :(</p>";
        exit;
    }
    
    if ($error_data === true) {
        
    }
    $recargas_pendientes_total = explode("</strong>", $fila[1]);
    echo "<hr>Recargas pendientes: " . $recargas_pendientes_total[1];
    $recargas_cobradas_total = explode("</strong>", $fila[2]);
    echo "Recargas cobradas: " . $recargas_cobradas_total[1];
    $recargas_caducadas_total = explode("</strong>", $fila[3]);
    echo "Recargas caducadas: " . $recargas_caducadas_total[1];
    $fila = explode("<p>", $contenido_descartado[2]);
    $recargas_pendientes_euros = explode("</strong>", $fila[1]);
    $euros_recarga_pendientes = explode(":", $recargas_pendientes_euros[0]);
    $euros_pendientes = str_replace(" ", "€", $euros_recarga_pendientes[1]);
    echo "<hr>Eypos pendientes: " . $euros_pendientes;
    $recargas_pendientes = explode("</strong>", $fila[1]);
    $recargas_pendientes = explode("Data caducidade", $text = \Soundasleep\Html2Text::convert($recargas_pendientes[1]));
    $tabla_pendientes = explode("\n", $recargas_pendientes[1]);

    echo "<hr>";
    for ($i = 1; $i < count($tabla_pendientes); $i++) {
        $datos = explode("", $tabla_pendientes[$i]);
        echo "€" . $datos[0] .  $datos[1] . "<br>";
    }

    $fila = explode("<p>", $contenido_descartado[3]);
    $recargas_pendientes_euros = explode("</strong>", $fila[1]);
    $euros_recarga_pendientes = explode(":", $recargas_pendientes_euros[0]);
    $euros_pendientes = str_replace(" ", "€", $euros_recarga_pendientes[1]);
    echo "<hr>Eypos cobrados: " . $euros_pendientes;
    $recargas_pendientes = explode("</strong>", $fila[1]);
    $recargas_pendientes = explode("Data ingreso", $text = \Soundasleep\Html2Text::convert($recargas_pendientes[1]));
    $tabla_pendientes = explode("\n", $recargas_pendientes[1]);

    echo "<hr>";
    for ($i = 1; $i < count($tabla_pendientes); $i++) {
        $datos = explode("", $tabla_pendientes[$i]);
        echo "€" . $datos[0] .  $datos[1] . "<br>";
    }

    $fila = explode("<p>", $contenido_descartado[4]);
    $recargas_pendientes_euros = explode("</strong>", $fila[1]);
    $euros_recarga_pendientes = explode(":", $recargas_pendientes_euros[0]);
    $euros_pendientes = str_replace(" ", "€", $euros_recarga_pendientes[1]);
    echo "<hr>Eypos caducados: " . $euros_pendientes;
    $recargas_pendientes = explode("</strong>", $fila[1]);
    $recargas_pendientes = explode("Data caducidade", $text = \Soundasleep\Html2Text::convert($recargas_pendientes[1]));
    $tabla_pendientes = explode("\n", $recargas_pendientes[1]);

    echo "<hr>";
    for ($i = 1; $i < count($tabla_pendientes); $i++) {
        $datos = explode("", $tabla_pendientes[$i]);
        echo "€" . $datos[0] .  $datos[1] . "<br>";
    }
}
