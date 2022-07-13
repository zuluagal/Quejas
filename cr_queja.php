<?php
		require ('conexion.php');
		
		$query = "SELECT id_depart, nb_depart FROM departamentos ORDER BY nb_depart";
		$resultado=$conexion->query($query);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Crear Queja</title>
		<!-- JS -->
		<script language="javascript" src="js/jquery-3.1.1.min.js"></script>
		<script language="javascript">
			$(document).ready(function(){
				$("#cbx_departamento").change(function () {
					$('#cbx_localidad').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
					
					$("#cbx_departamento option:selected").each(function () {
						id_depart = $(this).val();
						$.post("includes/getCiudad.php", { id_depart: id_depart }, function(data){
							$("#cbx_ciudad").html(data);
						});
					});
				})
			});
			
		</script>
		<!-- FIN JS -->
		<!-- BOOTSTRAP -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<!-- CSS -->
		<script src="https://kit.fontawesome.com/f6f7ead16d.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class="w">
			<header>
				<h1>Queja</h1>
				<nav>
					<ul>
						<li><a href="index.php" class="btn btn-info">Inicio</a></li>
					</ul>
				</nav>
			</header>
			<div class="container">
				<div class="col-sm-6 col-md-5 col-lg-6 container-fluid">
					<form class="form"  name="combo" action="" method="POST">
						
						<h2>Escribe una queja</h2>
						<textarea class="form-control" name="txtqueja" placeholder="Escribe tu queja aqui..." maxlength="150" minlength="30"></textarea>
						<p class="mx-mn-tamano">Min: 30 - Max: 150 caracteres</p>
						<select  class="form-select" name="cbx_departamento" id="cbx_departamento" required>
							<option value="0">Seleccionar Departamento</option>
							<?php while($row = $resultado->fetch_assoc()) { ?>
							<option value="<?php echo $row['id_depart']; ?>"><?php echo $row['nb_depart']; ?></option>
							<?php } ?>
						</select>
						<br>
						<select class="form-select" name="cbx_ciudad" id="cbx_ciudad" required>
							<option value="0">Seleccionar Ciudad</option>
						</select>
						<br>
						<input type="submit" class="btn btn-success" name="Crear" value="Crear Queja">
						<input type="submit" class="btn btn-info" name="Listar" value="Listar Quejas">
						<hr>
					</form>
					<br>
					<?php
						if(isset($_POST["Listar"])){
							//$sql      = 'SELECT queja, id_depart, id_ciudad FROM quejas';
							$sql  = 'SELECT * FROM quejas q 
									INNER JOIN departamentos d ON q.id_depart = d.id_depart
									INNER JOIN ciudades c ON q.id_ciudad = c.id_ciudad';
							$result   = $conexion->query($sql);
							//o fetch_assoc
							while ($fil = $result->fetch_array()){
								echo '
								<p><b>Queja</b></p>
								<textarea class="form-control" rows="3"
								value="" readonly> '.$fil['queja'].' </textarea><br>

								<p><b>Departamento</b></p>
								<input type=""  class="form-control" 
								value="'.$fil['nb_depart'].'" readonly /><br>

								<p><b>Ciudad</b></p>
								<input type=""  class="form-control" 
								value="'.$fil['nb_ciudad'].'" readonly /><br>
								<hr>
								';
					?>
				
					<?php
					}if (mysqli_num_rows($result) == 0) {
					echo"<p style='text-align: center; font-size: 20px; color: #dc3545;'>No se han encontrado datos.</p>".$conexion->error;
						}
					mysqli_close($conexion);
					}
					?>
				</div>
			</div>
		</div>
		<footer>
			<?php
				require_once('footer.php');
			?>
		</footer>
	</body>
</html>
<?php
if(isset($_POST['Crear'])){
	if ($conexion->connect_errno) {
			echo "Falló la conexión a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
		}else{
			$queja = $_POST['txtqueja'];
			$departamento = $_POST['cbx_departamento'];
			$ciudad = $_POST['cbx_ciudad'];
			$sql      = "INSERT INTO quejas (queja, id_depart, id_ciudad) ".
				"VALUES ('$queja', '$departamento', '$ciudad')";
			$result = $conexion->query($sql);
			if($result==true){
				echo"<p style='text-align: center; font-size: 20px; color: #198754;'>Queja Creada Exitosamente.</p>";
			}else{
				echo"<p style='text-align: center; font-size: 20px; color: #dc3545;'>Error al crear la queja. </p>".$conexion->error;
			}
		}
	mysqli_close($conexion);
}
?>