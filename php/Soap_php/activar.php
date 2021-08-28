<?php
        isset($_GET['id']) ? $i = $_GET['id'] : $i = '';
        date_default_timezone_set('America/Caracas');
        //Transformar la salida del WSDL a Array
        function obj2array($obj) {
                $out = array();
                foreach ($obj as $key => $val) {
                        switch(true) {
                                case is_object($val):
                                        $out[$key] = obj2array($val);
                                break;
                                case is_array($val):
                                        $out[$key] = obj2array($val);
                                break;
                                default:
                                        $out[$key] = $val;
                        }
                }
                return $out;
        }
        $crearlog = '';
        for ($j=0; $j <= 6; $j++) { 
                $log[$j] = 'actfachada'.$j.".log";
                if ($j == 2) {
                        $j += 1;
                }
        }
	$fecha =  date('h:i:s / d - F - Y');
	if ($i == 0) {
		$crearlog = fopen(__DIR__.'/logs/log.txt', 'a');
		fwrite($crearlog, ('Activada Total a las '.$fecha.PHP_EOL));
		fclose($crearlog);
	}else{
		$crearlog = fopen(__DIR__.'/logs/log.txt', 'a');
		fwrite($crearlog, ('Activada Fachada '.$i.' a las '.$fecha.PHP_EOL));
		fclose($crearlog);
	}
        ini_set('soap.wsdl_cache_enabled','0');
        ini_set('soap.wsdl_cache_ttl', '0');
        ini_set('default_socket_timeout', '40');
        if ($i == 0) {
                //instanciar el cliente SOAP
                $crearlog = fopen(__DIR__.'/logs/'.$log[$i],'w');
                fwrite($crearlog, date('h:i:s'));
                fclose($crearlog);
                for ($i=1; $i <= 5; $i++) {
                        try{
                                $Server="wsdl";
                                $client = new SoapClient($Server);
                                $param = array(); //parametros
                                $result=$client->funcion($param);
                                $result = obj2array($result);
                                if ($i==2){
                                        $i++;
                                }
                        } catch (Exception $e) {
                                echo "<br/><tr><td colspan=\"2\" align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Error activando en fachada ".$i."</b></font></td></tr>";
                                if ($i==2){
                                        $i++;
                                }
                        }
                }
                try {
                        $Server="wsdl";
                        $client = new SoapClient($Server);
                        $param = array(); //parametros
                        $result=$client->funcion($param);
                        $result = obj2array($result);
                } catch (Exception $e) {
                        echo "<br/><tr><td colspan=\"2\" align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Error activando en fachada 6</b></font></td></tr>";
                }
        }elseif ($i == 6) {
                $crearlog = fopen(__DIR__.'/logs/'.$log[$i],'w');
                fwrite($crearlog, date('h:i:s'));
                fclose($crearlog);
                try {
                        echo "<tr><td colspan=\"2\" align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Activando En Fachada ".$i."</b></font></td></tr>";
                        $Server="wsdl";
                        $client = new SoapClient($Server);
                        $param = array(); //parametros
                        $result=$client->funcion($param);
                        $result = obj2array($result);
                } catch (Exception $e) {
                        echo "<br/><tr><td colspan=\"2\" align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Error activando en fachada 6</b></font></td></tr>";
                }
        }else{
                $crearlog = fopen(__DIR__.'/logs/'.$log[$i],'w');
                fwrite($crearlog, date('h:i:s'));
                fclose($crearlog);
                try {
                        echo "<tr><td colspan=\"2\" align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Activando En Fachada ".$i."</b></font></td></tr>";
                        $Server="wsdl";
                        $client = new SoapClient($Server);
                        $param = array(); //parametros
                        $result=$client->funcion($param);
                        $result = obj2array($result);
                } catch (Exception $e) {
                        echo "<br/><tr><td colspan=\"2\" align=\"center\"><font face=\"Verdana\" size=\"2\"><b>Error activando En Fachada ".$i."</b></font></td></tr>";
                }
        }
?>
<script>
        window.open("index.php","_self")
</script>
