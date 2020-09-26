<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">

	<!-- Bootstrap 4 is mobile-first -->	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- -->

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

	<!--====  End of Section comment  ====-->

	<!--=====================================
	=            Font Awesome           	=
	======================================-->

	<script src="https://kit.fontawesome.com/ae92afae65.js" crossorigin="anonymous"></script>

	<!--====  End of Section comment  ====-->

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
			<p class="text-white h4 py-2">PASO 2: Insertar datos</p>		
            <p class="text-white py-2">En este punto, ya se tiene un nuevo archivo excel con los datos depurados, que podra descargar en el link inferior. 
            Ahora se utilizara este nuevo archivo para extraer los depurados e insertarlos en el archivo Backup de la estacion.
            A continuación adjunte el archivo excel backup de la estacion correspondiente. </p>	
		</span>

		<div >	

			<ul class="list-group pl-3 pr-3">			

				<!-- Nombre de documento analizado -->

				<li class="list-group-item">
					<div>
						<label><strong>Resultados: <?php echo Mensaje($bandera_de_informacion); ?>!</strong></label>
					</div>
                    
                    <div>                        
                        - <label><a href="" >Descargar archivo excel depurado aqui</a></label>
                    </div>

					<div>
						- <label>Archivo analizado: <u><?php echo $nombre_archivoEstacion; ?></u></label>                                       
					</div>

                    <div>
                        - <label>Se agregaron <strong><?php echo $contador_datos_agregados; ?></strong> filas.</label>                        
                    </div>

                    <div> 

                        <?php
                            $salto = -1;
                            foreach($datosAgregados_excelDepurado as $fila => $fecha)
                            {     
                                if($fila != 0 && $fecha != 0)
                                {
                                    echo "Fila=" . $fila. ", Fecha=" . $fecha;
                                    echo " - ";

                                    if($salto == 3)
                                    {
                                        echo "<br>";
                                        $salto = -1;
                                    }
                                }  
                                
                                $salto ++;
                            }   
                        ?>

                    </div>
				</li>
			</ul>

		</div>	

		

	</div>	

    <div class="container py-3">

        <form method="POST" action="copiador.php" enctype="multipart/form-data">            
    
            <div >	

                <ul class="list-group pl-3 pr-3">                    

                    <li class="list-group-item">
                        <div>
                            <label><strong>Adjunte el excel backup de la estacion:</strong></label>
                        </div>
                        <div>
                            <input type="file" name="excel-backup" id="excel-backup" accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" >
                        </div>
                    </li>					

                </ul>

            </div>

            <div class="container pt-3 ">

                <button id="submit" type="submit" class="btn btn-default btn-light float-left">Insertar</button>

            </div>

            <div class="container ">

                <button type="button" class="btn btn-default btn-light float-right " onclick="history.back()">Regresar</button>

            </div>

	    </form>

</div>
	
</body>
</html>
