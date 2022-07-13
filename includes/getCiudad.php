<?php
	
	require ('../conexion.php');
	
	$id_depart= $_POST['id_depart'];
	
	$queryM = "SELECT id_ciudad, nb_ciudad FROM ciudades WHERE id_depart = '$id_depart' ORDER BY nb_ciudad";
	$resultadoM = $conexion->query($queryM);
	
	$html= "<option value='0'>Seleccionar Ciudad</option>";
	
	while($rowM = $resultadoM->fetch_assoc())
	{
		$html.= "<option value='".$rowM['id_ciudad']."'>".$rowM['nb_ciudad']."</option>";
	}
	
	echo $html;
?>		