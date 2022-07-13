<?php require('conexion.php') ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Crear Ciudad</title>
		<!-- BOOTSTRAP -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<!-- CSS -->
		<script src="https://kit.fontawesome.com/f6f7ead16d.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class="w">
			<header>
				<h1>Ciudades</h1>
				<nav>
					<ul>
						<li><a href="index.php" class="btn btn-info">Inicio</a></li>
						<li><a href="cr_queja.php" class="btn btn-info">Crear Queja</a></li>
					</ul>
				</nav>
			</header>
			<div class="container">
				<div class="col-sm-6 col-md-5 col-lg-6 container-fluid">
					<form action="" method="post" class="form">
						<h2>Crea una ciudad</h2>
						<input type="text" name="name" placeholder="Nombre Ciudad" class="form-control" required><br>
						<!--<input type="number" name="id" placeholder="Id" class="form-control" required><br>-->
						<select class="form-select" name="departamento" aria-label="Default select example" required>
							<option value="0">Selecciona Departamento</option>
							<?php
							include("conexion.php");
								$departamentos = "SELECT * FROM departamentos";
								$result = mysqli_query($conexion,$departamentos);
								while ($list = mysqli_fetch_array($result)) {
							echo '<option value="'.$list['id_depart'].'">'.$list['nb_depart'].'</option>';
								}
							?>
						</select>
						<br>
						<input type="submit" class="btn btn-success" name="Crear" value="Crear Ciudad"><br>
						<br>
					</form>
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
			$nombre = $_POST['name'];
//			$id = $_POST['id'];
			$departamento = $_POST['departamento'];
			$sql      = "INSERT INTO ciudades (nb_ciudad, id_depart) ".
				"VALUES ('$nombre', '$departamento')";
			$result = $conexion->query($sql);
			if($result==true){
				echo"<p style='text-align: center; font-size: 20px; color: #198754;'>Ciudad Creada Exitosamente.</p>";
			}else{
				echo"<p style='text-align: center; font-size: 20px; color: #dc3545;'>Error al crear la Ciudad. </p>".$conexion->error;
			}
		}
	mysqli_close($conexion);
}
?>