<?php
	for ($i=0; $i <= 6; $i++) {
		if (file_exists(__DIR__."/logs/actfachada".$i.".log") == true) {
			unlink(__DIR__."/logs/actfachada".$i.".log");
		}
		if (file_exists(__DIR__."/logs/desacfachada".$i.".log") == true) {
			unlink(__DIR__."/logs/desacfachada".$i.".log");
		}
	}	
?>
<script>
	window.open("index.php","_self")
</script>
