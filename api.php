<?php

use Symfony\Component\HttpClient\HttpClient;
if (isset($_POST["numero"])) {
    if (strlen($_POST["numero"]) > 10) {
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
        if (strstr($contenido_descartado[0], $err_no_data) || strstr($contenido_descartado[0], "Tarxeta incorrecto")) {
            echo "<p class='error'>Esta tarxetiña non ten datos :(</p>";
            exit;
        }

        if ($error_data === true) {
        }
        $scrap = 2;
        echo '<script type="text/javascript">',
        'setkey(' . $numero_tratado . ');',
        '</script>';
        $recargas_pendientes_total = explode("</strong>", $fila[1]);
        echo "<div class='tabla-datos-head'><h2>Resume recargas:</h2></div><div class='tabla-datos'><p><i class='fas fa-credit-card'></i> Pendentes: " . $recargas_pendientes_total[1] . "</p>";
        $recargas_cobradas_total = explode("</strong>", $fila[2]);
        echo "<p><i class='fas fa-money-bill-wave'></i> Cobradas: " . $recargas_cobradas_total[1]. "</p>";
        $recargas_caducadas_total = explode("</strong>", $fila[3]);
        echo "<p><i class='fas fa-sad-cry'></i> Caducadas: " . $recargas_caducadas_total[1] . "</p></div>";
        if (strstr($contenido_descartado[$scrap], 'Recargas pendentes')) {
            $fila = explode("<p>", $contenido_descartado[$scrap]);
            $recargas_pendientes_euros = explode("</strong>", $fila[1]);
            $euros_recarga_pendientes = explode(":", $recargas_pendientes_euros[0]);
            $euros_pendientes = str_replace(" ", "€", $euros_recarga_pendientes[1]);
            echo "<div class='tabla-datos-head'><h2>Pendente de reembolso: " . $euros_pendientes . "</h2></div>";
            $recargas_pendientes = explode("</strong>", $fila[1]);
            $recargas_pendientes = explode("Data caducidade", $text = \Soundasleep\Html2Text::convert($recargas_pendientes[1]));
            $tabla_pendientes = explode("\n", $recargas_pendientes[1]);
            echo "<div class='tabla-datos'>";
            for ($i = 1; $i < count($tabla_pendientes); $i++) {
                $datos = explode("", $tabla_pendientes[$i]);
                $dinero = str_replace(" ", "", $datos[0]);
                echo  $dinero . "€ Antes do " .  $datos[1] . "<br>";
            }
            echo "</div>";
            $scrap++;
        }
        if (strstr($contenido_descartado[$scrap], 'Recargas cobradas')) {
            $fila = explode("<p>", $contenido_descartado[$scrap]);
            $recargas_pendientes_euros = explode("</strong>", $fila[1]);
            $euros_recarga_pendientes = explode(":", $recargas_pendientes_euros[0]);
            $euros_pendientes = str_replace(" ", "€", $euros_recarga_pendientes[1]);
            echo "<div class='tabla-datos-head'><h2>Cobrado xa: " . $euros_pendientes. "</h2></div>";
            $recargas_pendientes = explode("</strong>", $fila[1]);
            $recargas_pendientes = explode("Data ingreso", $text = \Soundasleep\Html2Text::convert($recargas_pendientes[1]));
            $tabla_pendientes = explode("\n", $recargas_pendientes[1]);

            echo "<div class='tabla-datos'>";
            for ($i = 1; $i < count($tabla_pendientes); $i++) {
                $datos = explode("", $tabla_pendientes[$i]);
                $dinero = str_replace(" ", "", $datos[0]);
                echo  $dinero . "€ " .  $datos[1] . "<br>";
            }
            echo "</div>";
            $scrap++;
        }
        if (strstr($contenido_descartado[$scrap], 'Recargas caducadas')) {
            $fila = explode("<p>", $contenido_descartado[$scrap]);
            $recargas_pendientes_euros = explode("</strong>", $fila[1]);
            $euros_recarga_pendientes = explode(":", $recargas_pendientes_euros[0]);
            $euros_pendientes = str_replace(" ", "€", $euros_recarga_pendientes[1]);
            echo "<div class='tabla-datos-head'><h2>Caducado: " . $euros_pendientes. "</h2></div>";
            $recargas_pendientes = explode("</strong>", $fila[1]);
            $recargas_pendientes = explode("Data caducidade", $text = \Soundasleep\Html2Text::convert($recargas_pendientes[1]));
            $tabla_pendientes = explode("\n", $recargas_pendientes[1]);

            echo "<div class='tabla-datos'>";
            for ($i = 1; $i < count($tabla_pendientes); $i++) {
                $datos = explode("", $tabla_pendientes[$i]);
                $dinero = str_replace(" ", "", $datos[0]);
                echo  $dinero . "€ " .  $datos[1] . "<br>";
            }
            echo "</div>";
            $scrap++;
        }
        
    }
    
}