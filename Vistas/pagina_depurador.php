<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">

	<!-- Bootstrap 4 is mobile-first -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<!--=====================================
	=            Bootstrap 4 CDN            =
	======================================-->

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

	<!--=====================================
	=            Font Awesome           	=
	======================================-->

	<script src="https://kit.fontawesome.com/ae92afae65.js" crossorigin="anonymous"></script>

	<!--=====================================
	=	            JQUERY   	        	=
	======================================-->

	<!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 

</head>

<body class="bg-dark">

	<!--=====================================
	=           	 TITULO           	    =
	======================================-->

	<div class="container-fluid">
		<p class="text-center text-white h2 py-3">ANALIZADOR DE DATOS</p>
	</div>

	<!--=====================================
	=                 CUERPO           	    =
	======================================-->

	<div class="container">

		<span>
			<p class="text-white h4 py-2">Resultados</p>

		</span>

		<div>

			<ul class="list-group pl-3 pr-3">

				<!-- Nombre de documento analizado -->

				<li class="list-group-item">
					<div>
						<label><strong>Resultados: <?php echo Mensaje($bandera_de_informacion); ?>!</strong></label>
					</div>

					<div>
						- <label><a href="../creados/Modificado - <?php echo $nombre_archivoEstacion; ?>">Descargar archivo excel de la estacion depurado aqui</a></label>
					</div>

					<div>
						- <label><a href="../creados/Modificado - <?php echo $nombre_archivoBackup; ?>">Descargar archivo excel backup de la estacion aqui</a></label>
					</div>

					<!-- <div>
						- <label><a href="  ">Descargar archivo de texto plano aqui</a></label>
					</div> -->

					<div>
						- <label>Nombre archivo estacion analizado: <u><?php echo $nombre_archivoEstacion; ?></u></label>
					</div>

					<div>
						- <label>Nombre archivo backUp analizado: <u><?php echo $nombre_archivoBackup; ?></u></label>
					</div>

					<div>
						- <label>Se agregaron <strong><?php echo $maxFilas_excelDepurado; ?></strong> filas en el archivo backUp.</label>
					</div>

					<div>
						- <label>Se agregaron <strong><?php echo $contador_datos_agregados; ?></strong> filas en el archivo estacion.</label>
					</div>

					<div>

						<?php
						$salto = -1;
						foreach ($datosAgregados_excelDepurado as $fila => $fecha) {
							if ($fila != 0 && $fecha != 0) {
								echo "Fila=" . $fila . ", Fecha=" . $fecha;
								echo " - ";

								if ($salto == 3) {
									echo "<br>";
									$salto = -1;
								}
							}

							$salto++;
						}
						?>

					</div>

				</li>
			</ul>

			<div class="container pt-3">

				<button type="button" class="btn btn-default btn-light float-right " onclick="history.back()">Regresar</button>

			</div>

		</div>

	</div>

</body>

</html>