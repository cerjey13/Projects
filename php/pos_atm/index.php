<?php
	/* Creado por Franber Berroteran / abril 2020
	Banco Mercantil */
    header('Content-Type: text/html; charset=UTF-8', false);
	date_default_timezone_set('America/La_Paz');
?>
<!DOCTYPE html5>
<html lang="es">
        <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>ATM/POS</title>
                <link rel="icon" type="image/jgp" href="imgs/logo_mercantil.jpg">
                <link href="css/bootstrap.min.css" rel="stylesheet">
                <script>
                    function pageloadEvery(t) {
                    setTimeout('location.reload(true)', t);
                    }
                </script>
               
    </head>
    <body onload="javascript:pageloadEvery(30000);">
        <?php
            $out = exec('C:\wamp64\www\trabajo\php\pos_atm\starting.py');
            $myFile = "output.txt"; //archivo con los datos
            $datos = file($myFile); 
            $tam = count($datos); //tamaño de los datos para saber si hay algun error   
        ?>
        <h2 class="text-center">Monitor B24</h2>
        <div class="container ">
            <table width=255 align="center" class="table-striped table-bordered">
                <thead>
                    <tr>
                        <th bgcolor=#949292 scope="col" class="text-center">NODOS</th>
                        <th bgcolor=#949292 scope="col" class="text-center">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">STARTED</td>
                        <?php $color = ($datos[0] == 727 ? '<center><img src="img/boton_verde.gif"></img></center>' : '<center><img src="img/boton_rojo.gif" alt="Alarma"></img></center>');
                            echo "<td>".$color."</td>";
                        ?>
                    </tr>
                    <tr>
                        <td class="text-center">STARTING</td>
                        <?php $color = ($datos[1] == 17 ? '<center><img src="img/boton_verde.gif"></img></center>' : '<center><img src="img/boton_rojo.gif" alt="Alarma"></img></center>');
                            echo "<td>".$color."</td>";
                        ?>
                    </tr>
                    <tr>
                        <td class="text-center">QUEQUE</td>
                        <?php $color = ($datos[2] == 8 ? '<center><img src="img/boton_verde.gif"></img></center>' : '<center><img src="img/boton_rojo.gif" alt="Alarma"></img></center>');
                            echo "<td>".$color."</td>";
                        ?>
                    </tr>
                </tbody>
            </table>
            <?php 
                if ($tam > 3){
                    echo "<table border = 1><tr><td>Error en:</td></tr>";
                        for ($i=3; $i < $tam; $i++) { 
                            echo "<tr><td>".$datos[$i]."</td></tr>";
                        }
                    echo "</table>";
                }
            ?>
            
        </div>
        <script src="js/jquery.slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>