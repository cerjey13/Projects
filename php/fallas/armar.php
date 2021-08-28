<?php
        header('Content-Type: text/html; charset=UTF-8');
        date_default_timezone_set('America/Caracas');
        $fallas = $_POST['falla'];
        $log = fopen("logs/log.txt",'a');
        fwrite($log, "Se escribio a las: ".date("Y-m-d H:i:s")."\n");
        fclose($log);
        $texto = fopen("logs/log.".date("Y-m-d").".txt",'w');
        fwrite($texto, $fallas);
        fclose($texto);
        header('location:index.php');
?>
