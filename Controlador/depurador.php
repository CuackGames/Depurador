<?php

/* ============================================================================================================ */

//llama al autoload
require '../vendor/autoload.php';

//carga la clase PhpSpreadsheet usando nameSpaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\IOFactory;

//llama a la clase writer/xlsx para crear el archivo xlsx
use PhpOffice\PhpSpreadsheet\Writer\Xls;

/* ============================================================================================================ */

	$bandera_de_informacion = 0;			//variable para mostrar mensaje en la pantalla
	$variable_en_pantalla = 0;				//variable para mostrar el nombre del archivo en la pantalla
	$contador_horas = 0;					//variable para contar las horas de cada dia, y comparar con los datos medidos. Asi se comprobara si se salto alguna hora
	$contador_tmp = 0;						//variable para almacenar temporalmente el dato consultado en ela rchivo original
	$error_en_fila = false;					//booleano para activar en caso de descubrir que faltan los datos de una fila
	$fila_nuevoExcel = 1;					//variable para llevar el orden de las filas del nuevo excel, en elq eu se estan copiando los datos
	$columna_nuevoExcel = 1;				//variable para llevar el orden de las columnas del nuevo excel, en el que se estan copiando los datos

/* ============================================================================================================ */

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{		

		/*========================================================================
		=            TOMAMOS LOS ARCHIVOS ENVIADOS POR VARIABLES POST            =
		========================================================================*/

		//obtenemos el nombre del archivo
		$nombre_archivoEstacion = $_FILES['excel-estacion']['name'];

		//mostramos en pantalla el nombre del archivo analizado
		$variable_en_pantalla = $_FILES['excel-estacion']['name'];

		//El nombre temporal del fichero en el cual se almacena el fichero subido en el servidor.
		$tmp_archivoEstacion = $_FILES['excel-estacion']["tmp_name"];


		/*====================================================================
		=            MOVEMOS EL ARCHIVO A LA CARPETA DEL PROYECTO            =
		====================================================================*/
	
		move_uploaded_file($tmp_archivoEstacion, "../cargados/$nombre_archivoEstacion");

		
		/*=============================================================================================
		=            CARGAMOS EL ARCHIVO ESTACION, OBTENEMOS EL NUMERO DE FILAS Y COLUMNAS            =
		=============================================================================================*/

		//cargamos el documento
		$documentoEstacion = IOFactory::load("../cargados/$nombre_archivoEstacion");

		//obtenemos la primera hoja del documento
		$hojaActual_documentoEstacion = $documentoEstacion -> getSheet(0);

		//obtenemos el mayor numero de filas
		$numeroMayor_filas = $hojaActual_documentoEstacion -> getHighestRow();

		//obtenemos la mayor letra de las columnas
		$letraMayor_columnas = $hojaActual_documentoEstacion -> getHighestColumn();

		//obtenemos el numero de la mayor letra de las columnas
		$numeroMayor_columnas = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayor_columnas); 


		/*========================================================================================
		=            CREAMOS EL NUEVO ARCHIVO DONDE COPIAREMOS LOS DATOS YA DEPURADOS            =
		========================================================================================*/
		
		//crear un nuevo objeto de la clase spreadsheet. para el nuevo doc. excel
		$nuevoExcel = new Spreadsheet();		

		//obtiene la hoja activa actual(primera hoja). para el nuevo doc excel.
		$hojaActual_nuevoExcel = $nuevoExcel -> getActiveSheet();

		//titulo de la hoja
		$hojaActual_nuevoExcel ->setTitle("Datos metereologicos depurados");
		$hojaActual_nuevoExcel->setCellValueByColumnAndRow(11, 1, "fila-insertada");
		$hojaActual_nuevoExcel->setCellValueByColumnAndRow(12, 1, "contador-horas");
		$hojaActual_nuevoExcel->setCellValueByColumnAndRow(13, 1, "RAIN depurada");
		$hojaActual_nuevoExcel->setCellValueByColumnAndRow(14, 1, "RAIN RATE x0.1");	//dividido entre 10
		$hojaActual_nuevoExcel->setCellValueByColumnAndRow(15, 1, "RAD.SOLAR x10");				


		/*===================================================================================================================================================================
		=            RECORREMOS LAS CELDAS DEL ARCHIVO ESTACION HORIZONTALMENTE DE IZQUEIRDA A DERECHA, INICIANDO EN LA CELDA A2 Y AGREGAMOS LAS FILAS FALTANTES            =
		===================================================================================================================================================================*/
				
		//iteramos en las celdas del documento cargado, atraves de sus filas y columnas
		for($fila = 2; $fila <= $numeroMayor_filas; $fila++)		
		{			
			//contamos las filas para luego comparar la cantidad de datos por dia con el numero de filas. Deben ser la misma cantidad. Es decir 24, de 0 a 23
			if($fila_nuevoExcel >= 3)
			{
				$contador_horas++;
			}			

			//si el contador_horas llega a 24 se reinicia a 0
			if($contador_horas >= 24)
			{
				$contador_horas = 0;
			}		

			//Iniciamos el proceso en la primera columna. Con este for recorreremos todas las columnas de la fila correspondiente
			for($columna = 1; $columna <= $numeroMayor_columnas; $columna++)
			{		
				//obtenemos la celda indicada
				$valorFormateado = $hojaActual_documentoEstacion -> getCellByColumnAndRow($columna, $fila)-> getFormattedValue();			

				if($valorFormateado == '---')
				{
					$valorFormateado = -999;
				}
				
				//guardamos el dato de hora en una variable temporal
				if($columna == 2)
				{				
					//guardamos el dato en una variable temporal. El dato guardado es hora
					$contador_tmp = $valorFormateado;

					//si la variable temporal, es diferente a contador_horas, quiere decir que en el archivo original falta el dato de la hora indicada (contador_horas)
					if($contador_tmp != $contador_horas)
					{			
						//Activa el booleano, apra que durante esta fila, se copien los datos de la fila anterior
						$error_en_fila = true;
					}
				}				

				//si el booleano esta en true, queire decir que en la columna 2 hubo evidencia de que falto datos de una hora especifica
				if($error_en_fila == true)
				{
					//si estamos en la columna 2
					if($columna == 2)
					{
						//En la celda que estamos creando, de la hora faltante, copiamos el dato de la celda de arriba
						$hojaActual_nuevoExcel->setCellValueByColumnAndRow(11, $fila_nuevoExcel, "X");

						//guardamos en la celda correspondiente el dato correcto guardado en contador_horas
						$hojaActual_nuevoExcel->setCellValueByColumnAndRow($columna_nuevoExcel, $fila_nuevoExcel, $contador_horas);						
						$columna_nuevoExcel++;
					}
					else
					{
						//numero de la fila anterior
						$filaAnterior = $fila - 1 ;						

						//dato de la celda de arriba, a la que no existe
						$valorAnterior = $hojaActual_documentoEstacion -> getCellByColumnAndRow($columna, $filaAnterior)-> getFormattedValue();					

						if($valorAnterior == '---')
						{
							$valorAnterior = -999;
						}

						//En la celda que estamos creando, de la hora faltante, copiamos el dato de la celda de arriba
						$hojaActual_nuevoExcel->setCellValueByColumnAndRow($columna_nuevoExcel, $fila_nuevoExcel, $valorAnterior);							
						$columna_nuevoExcel++;					
					
					}			
									
				}				
				else 				
				{		

					//si el booleano no esta activo. Queire decir que los datos van bien , asi que los copiamos normalmente
					$hojaActual_nuevoExcel->setCellValueByColumnAndRow($columna_nuevoExcel, $fila_nuevoExcel, $valorFormateado);		
						
					$columna_nuevoExcel++;
					
					//esto apra que no me cambie el titulo de la columna en la fila 1, y solo guarde el contador un vez por fila
					if($fila >= 3 && $columna == 1)
					{
						//guardamos en una columna extra, los conteos de las horas hechos por contador_horas
						$hojaActual_nuevoExcel->setCellValueByColumnAndRow(12, $fila_nuevoExcel, $contador_horas);	
					}								

				}
			}

			//reiniciamos la variable columna_nuevoExcel, que lleva el conteo de las columnas del nuevo excel generado
			$columna_nuevoExcel = 1;
			$fila_nuevoExcel++;
			
			//si el booleano esta en true
			if($error_en_fila == true)
			{
				//al finalizar el for, se pone el falso el booleano, para que en el siguiente ciclo, el analisis inicie de cero
				$error_en_fila = false;

				//se reduce la variable del for que lleva el conteo de las filas, apra que vuelva a analizar el dato de la fila que hubo discrepancia con la variable contador_horas
				$fila--;				
			}						

		}


		/*=================================================================================================
		=            CREAMOS COLUMNAS 13, 14 Y 15, APARTIR DE LA CORRECCION DE LAS COLUMNAS 8, 9 Y 10            =		=================================================================================================*/		

		//obtenemos el mayor numero de filas
		$maxfilas_nuevoExcel = $hojaActual_nuevoExcel -> getHighestRow();

		//iteramos en las filas del nuevo excel. Las columnas no por que son fijas
		for($fila = 2; $fila <= $maxfilas_nuevoExcel; $fila++)
		{
			//9=H, 10=I, 11=J, 12=k, 13=L, 14=M, 15=N
			//H se copia en M
			//I se copia en N
			//J se copia en O		

			//obtenemos el valor indicada
			$valor_nuevoExcel = $hojaActual_nuevoExcel -> getCellByColumnAndRow(8, $fila) -> getFormattedValue();
		
			//si el valor es cero
			if($valor_nuevoExcel == 0)
			{
				//se copia cero
				$hojaActual_nuevoExcel ->setCellValueByColumnAndRow(13, $fila, '0');
			}
			elseif ($valor_nuevoExcel > 0) 
			{
				//si es mayor a cero
				//buscamos el valor de la fila anterior
				$fila_previa = $fila -1;

				//consultamos la celda de arriba
				$valorPrevio_nuevoExcel = $hojaActual_nuevoExcel -> getCellByColumnAndRow(8, $fila_previa)-> getFormattedValue();				

				//si el valor de la celda de arriba es mayor a cero
				if($valorPrevio_nuevoExcel > 0)
				{
					//en la celda actual, se copia cero
					$hojaActual_nuevoExcel ->setCellValueByColumnAndRow(13, $fila, '0');
				}
				else
				{
					//se copia el valor tal cual venga
					$hojaActual_nuevoExcel ->setCellValueByColumnAndRow(13, $fila, $valor_nuevoExcel);
				}								
			}	
 			
 			//copiamos en las celdas 14 y 15, los datos de las celdas 9 y 10, con sus respectivas operaciones
			$hojaActual_nuevoExcel ->setCellValueByColumnAndRow(14, $fila, '=I'.$fila.'/10'); 
			$hojaActual_nuevoExcel ->setCellValueByColumnAndRow(15, $fila, '=J'.$fila.'*10'); 		

		}			


		/*==========================================================
		=            CENTRAMOS Y AJUSTAMOS LOS ESPACIOS            =
		==========================================================*/			

		$alineacion_nuevoExcel = $hojaActual_nuevoExcel -> getStyle('A1:Z1000') -> getAlignment();		
		$alineacion_nuevoExcel->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$letras = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O",);

		foreach ($letras as $value) 
		{
			$dimensionColumnas_nuevoExcel = $hojaActual_nuevoExcel -> getColumnDimension($value) ->setAutoSize(true);				
		}
		

		/*==================================================================================
		=            GUARDAMOS EL NUEVO ARCHIVO LUEGO DEL PROCESO DE DEPURACION            =
		==================================================================================*/

		$writer = new Xls($nuevoExcel);
		$writer->save('../creados/Datos metereologicos depurados.xls');
				

		$bandera_de_informacion = 101;			

	}
	else
	{
		$bandera_de_informacion = 404;		
	}

/* ============================================================================================================ */

	function Mensaje($numero)
	{
		switch($numero)
		{
			case 0:
				$mensaje = " ";
				break;

			case 100: 
				$mensaje = "Depuracion completa";
				break;

			case 101:
				$mensaje = "Vamos bien!";
				break;

			case 102:
				$mensaje = "Falto adjuntar uno de los elementos necesarios";
				break;

			case 404:
				$mensaje = "Error";
				break;
		}

		return $mensaje;
	}

/* ============================================================================================================ */



?>

<!-- ========================================================================================================= -->

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
		<p class="text-center text-white h2 py-3">DEPURADOR</p>
	</div>

	<!--=====================================
	=                 CUERPO           	    =
	======================================-->

	<div class="container">

		<span>
			<p class="text-white h4 py-2">Resultados del análisis</p>		
		</span>

		<div >	

			<ul class="list-group pl-3 pr-3">

				<!-- Link de descarga de documento -->				

				<li class="list-group-item">

					<a href="" >Descargar archivo excel</a>
					
				</li>

				<!-- Nombre de documento analizado -->

				<li class="list-group-item">
					<div>
						<label><strong>Documento analizado</strong></label>
					</div>
					<div>
						<?php echo $variable_en_pantalla; ?>
					</div>
				</li>

				<!-- Estado del proceso -->

				<li class="list-group-item">

					<?php echo Mensaje($bandera_de_informacion); ?>

				</li>

			</ul>

		</div>	

		<div class="container pt-3">

			<button type="button" class="btn btn-default btn-light float-right " onclick="history.back()">Regresar</button>

		</div>

	</div>	

	
</body>
</html>
