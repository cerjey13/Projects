<?php
 	header('Content-Type: text/html; charset=UTF-8');
	date_default_timezone_set('America/La_Paz');
?>
<!DOCTYPE html5>
<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel="icon" type="image/jgp" href="imgs/logo_mercantil.jpg">
		<script src="js/jquery-1.9.1.min.js"></script>
		<script src="js/jquery.confirm.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
			function init ( )
			{
				timeDisplay = document.createTextNode ( "" );
				document.getElementById("clock").appendChild ( timeDisplay );
			}
			function updateClock ( )
			{
				var currentTime = new Date ( );
				var currentHours = currentTime.getHours ( );
				var currentMinutes = currentTime.getMinutes ( );
				var currentSeconds = currentTime.getSeconds ( );

				// Rellenar las horas y minutos con 0 a la izquierda si es necesario
				currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
				currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

				// Elegir AM o PM segun convenga
				var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

				// Convertir las horas a formato de 12h si se necesita
				currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

				// Convertir la hora "0" en 12
				currentHours = ( currentHours == 0 ) ? 12 : currentHours;

				// Componer el string a mostrar
				var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

				// Refrescar el tiempo mostrado
				document.getElementById("clock").firstChild.nodeValue = currentTimeString;
			}
		</script>
	</head>
	<body bgcolor="white" onload="updateClock(); setInterval('updateClock()', 1000 )">
		<table width="450" border="0" cellspacing="1" cellpadding="2" align="center">
			<tr align="center">
				<td colspan="5"><img src="" alt=""><br><br></td> //imagen decorativa
			</tr>
		</table></br></br>
		<div>
			<h3><span style="margin-left: 20%" id="clock">&nbsp;</span></h3>
		</div>
			
		<?php
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
			for ($j=0; $j <= 6; $j++) { 
				$log[$j] = 'actfachada'.$j.".log";
				if ($j == 2) {
					$j += 1;
				}
			}
			$tiempo1 = '';
			ini_set('soap.wsdl_cache_enabled','0');
			ini_set('soap.wsdl_cache_ttl', '0');
			ini_set('default_socket_timeout', '30');
			echo "<table align=\"center\" border=1 width=60% height=40%>";
			echo "<tr><td colspan=\"8\" align=\"center\"><font face=\"Verdana\" size=\"4\"><b>****</b></font></td></tr>"; //nombre
			echo "<td colspan=\"3\" bgcolor=\"#ADAEAD\"><td bgcolor=\"#ADAEAD\" align=\"center\" colspan=\"5\"><font color=\"White\" face=\"Verdana\" size=\"-2\"><b>Contingencia</b></font></td></td>";
			echo "<tr align=\"center\">";
			echo "<td bgcolor=\"#ADAEAD\"><font face=\"Verdana\" size=\"-2\" color=\"White\"><b>Fachada</b></font></td>";
			echo "<td bgcolor=\"#ADAEAD\"><font face=\"Verdana\" size=\"-2\" color=\"White\"><b>Servidor</b></font></td>";
			echo "<td bgcolor=\"#ADAEAD\"><font face=\"Verdana\" size=\"-2\" color=\"White\"><b>Estado</b></font></td>";
			echo "<td bgcolor=\"#ADAEAD\"><font face=\"Verdana\" size=\"-2\" color=\"White\"><b>Activar</b></font></td>";
			echo "<td bgcolor=\"#ADAEAD\"><font face=\"Verdana\" size=\"-2\" color=\"White\"><b>Desactivar</b></font></td>";
			echo "<td bgcolor=\"#ADAEAD\"><font face=\"Verdana\" size=\"-2\" color=\"White\"><b>Hora de Activacion</b></font></td>";
			echo "<td bgcolor=\"#ADAEAD\"><font face=\"Verdana\" size=\"-2\" color=\"White\"><b>Hora de Desactivacion</b></font></td>";
			echo "<td bgcolor=\"#ADAEAD\"><font face=\"Verdana\" size=\"-2\" color=\"White\"><b>Duracion de Contingencia</b></font></td>";
			echo "</tr>";
			$desactivar = 0;
			for ($i=1;$i<=5;$i++){
				echo "<tr align=\"center\">";
				//instantiate the SOAP client
				try {
					$Server="wsdl"; //direccion del wsdl
					$client = new SoapClient($Server);
					$param="<soapenv:Envelope </soapenv:Envelope>"; //envelope
					$result=$client->Funcion($param); //nombre de la funcion soap
					$result = obj2array($result);
					echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">".$i."</td>"; //numero de la columna fachada
				 	echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">NOMBRE".$i."</td>"; //nombre de la columna servidor
					echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">".$result['###']['$$$']."</td>"; // ### = funcion de respuesta del soap ; $$$ = parametro
					$estado=$result['###']['$$$']; // ### = funcion de respuesta del soap ; $$$ = parametro
				 	if (strcmp(rtrim($estado),"NO Activada") == 0) {
				 		echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-primary\" id=\"activar".$i."\" title=\"Fachada ".$i."\"></td>";
						echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-default disabled\" id=\"desactivar".$i."\"></td>";
						//tiempo de activacion
						file_exists(__DIR__.'/logs/actfachada'.$i.'.log') == true ? $log = __DIR__.'/logs/actfachada'.$i.'.log' : $log = '';
						$log == '' ? $tiempo1 = "&nbsp" : $tiempo1 = file_get_contents($log);
						echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempo1."</b></font></td>";
						//tiempo hasta la desactivacion
						file_exists(__DIR__.'/logs/desacfachada'.$i.'.log') == true ? $log = __DIR__.'/logs/desacfachada'.$i.'.log' : $log = '';
						$log == '' ? $tiempo2 = "&nbsp" : $tiempo2 = file_get_contents($log);
						echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempo2."</b></font></td>";
						//tiempo total duracion
						try {
							$start_date = new DateTime($tiempo1);
							$since_start = $start_date->diff(new DateTime($tiempo2));
							$tiempoT = sprintf("%02d", $since_start->h).':'.sprintf("%02d", $since_start->i).':'.sprintf("%02d", $since_start->s);
						} catch (Exception $e) {
							//no existe tiempo;
						}
						if ($tiempo2 == '&nbsp'){
							echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>&nbsp</b></font>";
						}else {
							echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempoT."</b></font>";
						}
				 	}else{
				 		echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-default disabled\" id=\"activar".$i."\"></td>";
				 		echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-danger\" name=\"desactivar\"  id=\"desactivar".$i."\" title=\"Fachada ".$i."\"></td>";
						//tiempo de activacion
						if (file_exists(__DIR__.'/logs/actfachada'.$i.'.log') == true){
							$log = __DIR__.'/logs/actfachada'.$i.'.log';
							$tiempo1 = file_get_contents($log);
						}else{
							$crearlog = fopen(__DIR__.'/logs/actfachada'.$i.'.log','w');
               						fwrite($crearlog, date('h:i:s'));
							fclose($crearlog);
							$log = __DIR__.'/logs/actfachada'.$i.'.log';
							$tiempo1 = file_get_contents($log);
						}
						echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempo1."</b></font></td>";
						//tiempo hasta la desactivacion
						file_exists(__DIR__.'/logs/desacfachada'.$i.'.log') == true ? $log = __DIR__.'/logs/desacfachada'.$i.'.log' : $log = '';
						$log == '' ? $tiempo2 = "&nbsp" : $tiempo2 = file_get_contents($log);
						echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempo2."</b></font></td>";
						//tiempo total duracion
						try {
							$start_date = new DateTime($tiempo1);
							$since_start = $start_date->diff(new DateTime($tiempo2));
							$tiempoT = sprintf("%02d", $since_start->h).':'.sprintf("%02d", $since_start->i).':'.sprintf("%02d", $since_start->s);
						} catch (Exception $e) {
							//no existe tiempo;
						}
						if ($tiempo2 == '&nbsp'){
							echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>&nbsp</b></font>";
						}else {
							echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempoT."</b></font>";
						}
				 		$desactivar += 1;
				 	}
				 	if ($i==2){
						$i++;
					}
				} catch (Exception $e) {
					echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">".$i."</td>"; //numero de la columna fachada
				 	echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">NOMBRE".$i."</td>"; //nombre de la columna servidor
				 	echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">ERROR</td>"; //error de status si no responde
				 	echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-default disabled\" id=\"activar".$i."\" title=\"Fachada ".$i."\"></td>";
				 	echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-default disabled\" id=\"desactivar".$i."\"></td>";
					echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-2\">&nbsp</font></td>";
					echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-2\">&nbsp</font></td>";
					echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-2\">&nbsp</font></td>";
				 	if ($i==2){
						$i++; // saltarse el numero 2
					}
				}
				echo "</tr>";
			}
			echo "<tr align=\"center\">";
			try {
				$Server="wsdl"; //direccion del wsdl
				$client = new SoapClient($Server);
				$param="<soapenv:Envelope></soapenv:Envelope>"; // envelope
				$result=$client->funcion($param);
				$result = obj2array($result);
				echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">6</td>";
				echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">nombre distinto</td>";
				echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">".$result['###']['$$$']."</td>";
				$estado=$result['###']['$$$'];
				if (strcmp(rtrim($estado),"NO Activada") == 0) {
					echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-primary\" id=\"activar6\" title=\"Fachada 6\"></td>";
					echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-default disabled\" id=\"desactivar6\"></td>";
					//tiempo de activacion
					file_exists(__DIR__.'/logs/actfachada6.log') == true ? $log = __DIR__.'/logs/actfachada6.log' : $log = '';
					$log == '' ? $tiempo1 = "&nbsp" : $tiempo1 = file_get_contents($log);
					echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempo1."</b></font></td>";
					//tiempo hasta la desactivacion
					file_exists(__DIR__.'/logs/desacfachada6.log') == true ? $log = __DIR__.'/logs/desacfachada6.log' : $log = '';
					$log == '' ? $tiempo2 = "&nbsp" : $tiempo2 = file_get_contents($log);
					echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempo2."</b></font></td>";
					//tiempo total duracion
					try {
						$start_date = new DateTime($tiempo1);
						$since_start = $start_date->diff(new DateTime($tiempo2));
						$tiempoT = sprintf("%02d", $since_start->h).':'.sprintf("%02d", $since_start->i).':'.sprintf("%02d", $since_start->s);
					} catch (Exception $e) {
						//no existe tiempo;
					}
					if ($tiempo2 == '&nbsp'){
						echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>&nbsp</b></font>";
					}else {
						echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempoT."</b></font>";
					}
				}else{
					echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-default disabled\" id=\"activar6\"></td>";
					echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-danger\" name=\"desactivar6\"  id=\"desactivar6\" title=\"Fachada 6\"></td>";
					//tiempo de activacion
					if (file_exists(__DIR__.'/logs/actfachada6.log') == true){
						$log = __DIR__.'/logs/actfachada6.log';
						$tiempo1 = file_get_contents($log);
					}else{
						$crearlog = fopen(__DIR__.'/logs/actfachada6.log','w');
						fwrite($crearlog, date('h:i:s'));
						fclose($crearlog);
						$log = __DIR__.'/logs/actfachada6.log';
						$tiempo1 = file_get_contents($log);
					}
					echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempo1."</b></font></td>";
					//tiempo hasta la desactivacion
					file_exists(__DIR__.'/logs/desacfachada6.log') == true ? $log = __DIR__.'/logs/desacfachada6.log' : $log = '';
					$log == '' ? $tiempo2 = "&nbsp" : $tiempo2 = file_get_contents($log);
					echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempo2."</b></font></td>";
					//tiempo total duracion
					try {
						$start_date = new DateTime($tiempo1);
						$since_start = $start_date->diff(new DateTime($tiempo2));
						$tiempoT = sprintf("%02d", $since_start->h).':'.sprintf("%02d", $since_start->i).':'.sprintf("%02d", $since_start->s);
					} catch (Exception $e) {
						//no existe tiempo;
					}
					if ($tiempo2 == '&nbsp'){
						echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>&nbsp</b></font>";
					}else {
						echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempoT."</b></font>";
					}
					$desactivar += 1;
				}
			} catch (Exception $e) {
				echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">6</td>";
				echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">NOMBRE</td>";
				echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\">ERROR</td>";
				echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-default disabled\" id=\"activar6\" title=\"Fachada 6\"></td>";
				echo "<td bgcolor=\"#DEDFDE\"><button class=\"btn btn-default disabled\" id=\"desactivar6\"></td>";
				echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-2\">&nbsp</font></td>";
				echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>&nbsp</b></font>";
			}
			echo "</tr>";

			echo "<tr align=\"center\">";
			if ( $desactivar == 4 || $desactivar == 5){
				echo "<td colspan=\"5\" bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\"><button class=\"btn btn-danger\" id=\"contingencia\" title=\"Todas las Fachadas\">Desactivar Todo</button></td>";
			}else{
				echo "<td colspan=\"5\" bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\" color=\"Black\"><button class=\"btn btn-primary\" id=\"contingencia\" title=\"Todas las Fachadas\">Activacion Total</button></td>";
			}

			//tiempo de activacion
			file_exists(__DIR__.'/logs/actfachada0.log') == true ? $log = __DIR__.'/logs/actfachada0.log' : $log = '';
			$log == '' ? $tiempo1 = "&nbsp" : $tiempo1 = file_get_contents($log);
			echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempo1."</b></font></td>";
			//tiempo hasta la desactivacion
			file_exists(__DIR__.'/logs/desacfachada0.log') == true ? $log = __DIR__.'/logs/desacfachada0.log' : $log = '';
			$log == '' ? $tiempo2 = "&nbsp" : $tiempo2 = file_get_contents($log);
			echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempo2."</b></font></td>";
			//tiempo total duracion
			try {
				$start_date = new DateTime($tiempo1);
				$since_start = $start_date->diff(new DateTime($tiempo2));
				$tiempoT = sprintf("%02d", $since_start->h).':'.sprintf("%02d", $since_start->i).':'.sprintf("%02d", $since_start->s);
			} catch (Exception $e) {
				//no existe tiempo;
			}
			if ($tiempo2 == '&nbsp'){
				echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>&nbsp</b></font></tr>";
			}else {
				echo "<td bgcolor=\"#DEDFDE\"><font face=\"Verdana\" size=\"-1\"><b>".$tiempoT."</b></font></tr>";
			}
			echo "<td colspan=\"5\" align=\"center\" bgcolor=\"white\"><font face=\"Verdana\" size=\"-0\"></td>";
			echo "<td colspan=\"3\" align=\"center\" bgcolor=\"#DEDFDE\"><button class=\"btn btn-info\" id=\"destruirSesion\" title=\"Borrar horas\">LIMPIAR</td>";
			echo "</table></br></br>";
			
			echo "<table align=\"center\" border=1 width=400 class=\"col 6\" id=\"tabla1\"><td align=\"center\" colspan=\"4\" bgcolor=\"#DEDFDE\"><b>LEYENDA</b></td>";
			echo "<tr><td bgcolor=\"#DEDFDE\" align=\"center\" width=100><button class=\"btn btn-danger\"></td><td bgcolor=\"#DEDFDE\" align=\"center\">Esta activa</td></tr>";
			echo "<tr><td bgcolor=\"#DEDFDE\" align=\"center\" width=100><button class=\"btn btn-primary\"></td><td bgcolor=\"#DEDFDE\" align=\"center\">Esta desactivada</td></tr>";
			echo "</table>";
		?>
		<script>
			//BOTON ACTIVAR O DESACTIVAR TOTAL			
			$("#contingencia").confirm({
			    	title:"Confirmar acción",
			    	text: "Esta actividad es de cuidado, ¿Está seguro de ejecutarla?",
			    	confirm: function(button) {
					button.fadeOut(500).fadeIn(500);
			        alert("Se ejecutará la acción.");
					<?php
						if ( $desactivar == 4 || $desactivar == 5){
					?>
							window.open("desactivar.php?id=" + 0,"_self")
					<?php
						}else{
					?>
							window.open("activar.php?id=" + 0,"_self")
					<?php
						}
					?>
			        },
				cancel: function(button) {
					button.fadeOut(500).fadeIn(500);
			        alert("Ha cancelado la acción.");
					},
				confirmButton: "Si, lo estoy",
			   	cancelButton: "No"
		   	});
		   	//BOTON PARA LIMPIAR LAS HORAS DE ACTIVACION
		   	$("#destruirSesion").confirm({
			    	title:"Confirmar acción",
			    	text: "Borrala las horas de activacion, ¿Está seguro que desea limpiarlas?",
			    	confirm: function(button) {
					button.fadeOut(500).fadeIn(500);
					window.open("limpiar.php","_self")
			        },
				cancel: function(button) {
					button.fadeOut(500).fadeIn(500);
					},
				confirmButton: "Si",
			   	cancelButton: "No"
		   	});
			// BOTONES ACTIVAR O DESACTIVAR INDIVIDUALES
			var buttons = document.querySelectorAll('button');
			console.log(buttons);
			for (var i=0; i<buttons.length; ++i) {
			  buttons[i].addEventListener('mouseenter', obtener);
			}

			function obtener(e) {
				id = e.target.id;
				console.log(id);

				if (id == "activar1" || id == "activar2" || id == "activar4" || id == "activar5" || id == "activar6"){
					$("#" + id).confirm({
				    title:"Confirmar acción",
				    text: "Esta actividad es de cuidado, ¿Está seguro de ejecutarla?",
				    confirm: function(button) {
						button.fadeOut(500).fadeIn(500);
				        alert("Se ejecutará la acción.");
				        window.open("activar.php?id=" + id[7],"_self")
				        },
					cancel: function(button) {
						button.fadeOut(500).fadeIn(500);
				        alert("Ha cancelado la accion.");
						},
					confirmButton: "Si, lo estoy",
				    	cancelButton: "No"
				    	});
				};

				if (id == "desactivar1" || id == "desactivar2" || id == "desactivar4" || id == "desactivar5" || id == "desactivar6"){
					$("#" + id).confirm({
				    title:"Confirmar acción",
				    text: "Esta actividad es de cuidado, ¿Está seguro de ejecutarla?",
				    confirm: function(button) {
						button.fadeOut(500).fadeIn(500);
				        alert("Se ejecutará la acción.");
						window.open("desactivar.php?id=" + id[10],"_self")
				        },
					cancel: function(button) {
						button.fadeOut(500).fadeIn(500);
				        alert("Ha cancelado la accion.");
						},
					confirmButton: "Si, lo estoy",
				    	cancelButton: "No"
				    	});
				};	
			};
		</script>
	</body>
</html>
