<?php

use Symfony\Component\HttpClient\HttpClient;
?>


<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <meta charset="utf-8">
    <title>Transporte Metropolitano Galicia by CP</title>
    <link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name=”robots” content="index, nofollow">
    <meta name="Description" CONTENT="Páxina indepentende creada por Abraham by CP">
    <meta name="google" content="notranslate" />
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>

<style>
    * {
        font-family: 'Pattaya', sans-serif;
        font-size: 25px;
        text-align: center;
    }

    .submit_btn {
        font-size: 25px;
        background-color: #5E5E5E;
        /* Green */
        border: none;
        padding: 15px 32px;
        color: white;
        border-radius: 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        -webkit-appearance: none;
    }

    .error {
        color: #DA0B0B;
    }
</style>



<form name="buscaTarxetaForm" id="buscaTarxetaForm" method="post" action="" style="text-align: center;">
    <div style=" vertical-align: middle;">
        <label for="numero" style="font-size: 40px;">Número de Tarxeta</label> <br>
        <input style="font-size: 30px;" type="text" name="numero" size="20" width="100%" value="" placeholder="Escribe o número aqui" class="">
    </div>
    <p> <input class="submit_btn" type="submit" value="Buscar"></p>
</form>
<form action="" method="POST" id="txn_div" style="display: none;">
    <input type="hidden" id="txn" name="numero" value="">
    <input class="submit_btn" id="txn_btn" type="submit" value="">
</form>
<script>
function setkey(key){
    miStorage = window.localStorage;
    localStorage.setItem('txn', key);
}
window.onload = function(){
    miStorage = window.localStorage;
    var txn = localStorage.getItem('txn');
    if(localStorage.hasOwnProperty('txn')){
        document.getElementById("txn").value = txn;
        document.getElementById("txn_btn").value = txn;
        document.getElementById("txn_div").style.display = "block";
    }
}

</script>
<?php
if (isset($_POST["numero"])) {
    $hora = time();
    $texto = "";
    $numero_tratado = str_replace(" ", "", $_POST["numero"]);
    require('vendor/autoload.php');
    $url_xunta = "https://tmg.xunta.gal/consulta-de-bonificacions?p_p_id=tarxetaTMG_WAR_tarxetaTMG&p_p_lifecycle=1&p_p_state=normal&p_p_mode=view&p_p_col_id=column-2&p_p_col_count=1&_tarxetaTMG_WAR_tarxetaTMG__spage=%2Fportlet_action%2FtarxetaTMG%2FbuscaTarxeta&_tarxetaTMG_WAR_tarxetaTMG__sorig=%2Fportlet_action%2FtarxetaTMG%2FbuscaTarxeta";

    $httpClient = HttpClient::create();
    $response = $httpClient->request('POST', $url_xunta, [
        'body' => [
            'numero' => $numero_tratado,
        ]
    ]);
    error_reporting(E_ERROR | E_PARSE);
    $content = $response->getContent();
    $contenido = explode("\n", $content);
    $contenido_descartado = explode("<br>", $contenido[64]);
    //var_dump($contenido_descartado);
    $fila = explode("<p>", $contenido_descartado[1]);
    $err_no_data = "Non hai ningunha recarga";
    if (strstr($contenido_descartado[0], $err_no_data)) {
        echo "<p class='error'>Esta tarjetiña no tiene datos :(</p>";
        exit;
    }

    if ($error_data === true) {
    }
    $scrap = 2;
    echo '<script type="text/javascript">',
     'setkey('.$numero_tratado.');',
     '</script>'
;
    $recargas_pendientes_total = explode("</strong>", $fila[1]);
    echo "<hr>Recargas pendientes: " . $recargas_pendientes_total[1];
    $recargas_cobradas_total = explode("</strong>", $fila[2]);
    echo "Recargas cobradas: " . $recargas_cobradas_total[1];
    $recargas_caducadas_total = explode("</strong>", $fila[3]);
    echo "Recargas caducadas: " . $recargas_caducadas_total[1];
    if (strstr($contenido_descartado[$scrap], 'Recargas pendentes')) {
        $fila = explode("<p>", $contenido_descartado[$scrap]);
        $recargas_pendientes_euros = explode("</strong>", $fila[1]);
        $euros_recarga_pendientes = explode(":", $recargas_pendientes_euros[0]);
        $euros_pendientes = str_replace(" ", "€", $euros_recarga_pendientes[1]);
        echo "<hr>Dinero pendiente: " . $euros_pendientes;
        $recargas_pendientes = explode("</strong>", $fila[1]);
        $recargas_pendientes = explode("Data caducidade", $text = \Soundasleep\Html2Text::convert($recargas_pendientes[1]));
        $tabla_pendientes = explode("\n", $recargas_pendientes[1]);

        echo "<hr>";
        for ($i = 1; $i < count($tabla_pendientes); $i++) {
            $datos = explode("", $tabla_pendientes[$i]);
            $dinero = str_replace(" ", "", $datos[0]);
            echo  $dinero."€ " .  $datos[1] . "<br>";
        }
        $scrap++;
    }
    if (strstr($contenido_descartado[$scrap], 'Recargas cobradas')) {
        $fila = explode("<p>", $contenido_descartado[$scrap]);
        $recargas_pendientes_euros = explode("</strong>", $fila[1]);
        $euros_recarga_pendientes = explode(":", $recargas_pendientes_euros[0]);
        $euros_pendientes = str_replace(" ", "€", $euros_recarga_pendientes[1]);
        echo "<hr>Dinero cobrado: " . $euros_pendientes;
        $recargas_pendientes = explode("</strong>", $fila[1]);
        $recargas_pendientes = explode("Data ingreso", $text = \Soundasleep\Html2Text::convert($recargas_pendientes[1]));
        $tabla_pendientes = explode("\n", $recargas_pendientes[1]);

        echo "<hr>";
        for ($i = 1; $i < count($tabla_pendientes); $i++) {
            $datos = explode("", $tabla_pendientes[$i]);
            $dinero = str_replace(" ", "", $datos[0]);
            echo  $dinero."€ " .  $datos[1] . "<br>";
        }
        $scrap++;
    }
    if (strstr($contenido_descartado[$scrap], 'Recargas caducadas')) {
        $fila = explode("<p>", $contenido_descartado[$scrap]);
        $recargas_pendientes_euros = explode("</strong>", $fila[1]);
        $euros_recarga_pendientes = explode(":", $recargas_pendientes_euros[0]);
        $euros_pendientes = str_replace(" ", "€", $euros_recarga_pendientes[1]);
        echo "<hr>Dinero caducado: " . $euros_pendientes;
        $recargas_pendientes = explode("</strong>", $fila[1]);
        $recargas_pendientes = explode("Data caducidade", $text = \Soundasleep\Html2Text::convert($recargas_pendientes[1]));
        $tabla_pendientes = explode("\n", $recargas_pendientes[1]);

        echo "<hr>";
        for ($i = 1; $i < count($tabla_pendientes); $i++) {
            $datos = explode("", $tabla_pendientes[$i]);
            $dinero = str_replace(" ", "", $datos[0]);
            echo  $dinero."€ " .  $datos[1] . "<br>";
        }
        $scrap++;
    }
}


?>



<script>
    if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    document.documentElement.requestFullscreen({ navigationUI: 'hide' });
    navigator.serviceWorker.register('pwabuilder-sw/pwabuilder-sw.js');
  });
}
</script>