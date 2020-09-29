<?php

/* ============================================================================================================ */

//llama al autoload
require '../vendor/autoload.php';

//carga la clase PhpSpreadsheet usando nameSpaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\IOFactory;

//llama a la clase writer/xlsx para crear el archivo xlsx
use PhpOffice\PhpSpreadsheet\Writer\Xls;
set_time_limit(500);

/* ============================================================================================================ */

	$bandera_de_informacion = 0;			//variable para mostrar mensaje en la pantalla
	$contador_datos_agregados = 0;
	$fechaAgregada_excelDepurado = 0;
	$datosAgregados_excelDepurado[] = 0;
	$contador_horas = 0;					//variable para contar las horas de cada dia, y comparar con los datos medidos. Asi se comprobara si se salto alguna hora
	$contador_tmp = 0;						//variable para almacenar temporalmente el dato consultado en ela rchivo original
	$error_en_fila = false;					//booleano para activar en caso de descubrir que faltan los datos de una fila
	$fila_excelDepurado = 1;					//variable para llevar el orden de las filas del nuevo excel, en elq eu se estan copiando los datos
	$columna_excelDepurado = 1;				//variable para llevar el orden de las columnas del nuevo excel, en el que se estan copiando los datos

/* ============================================================================================================ */

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{		

		/*========================================================================
		=            TOMAMOS LOS ARCHIVOS ENVIADOS POR VARIABLES POST            =
		========================================================================*/

		//obtenemos el nombre de los archivos cargados
		$nombre_archivoEstacion = $_FILES['excel-estacion']['name'];
		//$nombre_archivoBackup = $_FILES['excel-backup']['name'];	

		//El nombre temporal del fichero en el cual se almacenan los ficheros subidos en el servidor.
		$tmp_archivoEstacion = $_FILES['excel-estacion']["tmp_name"];
		//$tmp_archivoBackup = $_FILES['excel-backup']['tmp_name'];

		/*====================================================================
		=            MOVEMOS EL ARCHIVO A LA CARPETA DEL PROYECTO            =
		====================================================================*/ 
	
		move_uploaded_file($tmp_archivoEstacion, "../cargados/$nombre_archivoEstacion"); 
		//move_uploaded_file($tmp_archivoBackup, "../cargados/$nombre_archivoBackup" );
		
		/*=============================================================================================
		=            CARGAMOS EL ARCHIVO ESTACION, OBTENEMOS EL NUMERO DE FILAS Y COLUMNAS            =
		=============================================================================================*/

		//cargamos los documentos cargados
		$documentoEstacion = IOFactory::load("../cargados/$nombre_archivoEstacion");

		//obtenemos la primera hoja de cada documento
		$hojaActual_documentoEstacion = $documentoEstacion -> getSheet(0);

		//obtenemos el mayor numero de filas del archivo estacion
		$maxFilas_documentoEstacion = $hojaActual_documentoEstacion -> getHighestRow();

		//obtenemos la mayor letra de las columnas del archivo estacion
		$letraMayor_columnas = $hojaActual_documentoEstacion -> getHighestColumn();

		//obtenemos el numero de la mayor letra de las columnas del archivo estacion
		$maxColumnas_documentoEstacion = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayor_columnas); 


		/*========================================================================================
		=            CREAMOS EL NUEVO ARCHIVO DONDE COPIAREMOS LOS DATOS YA DEPURADOS            =
		========================================================================================*/
		
		//crear un nuevo objeto de la clase spreadsheet. para el nuevo doc. excel
		$excelDepurado = new Spreadsheet();		

		//obtiene la hoja activa actual(primera hoja). para el nuevo doc excel.
		$hojaActual_excelDepurado = $excelDepurado -> getActiveSheet();

		//titulo de la hoja
		$hojaActual_excelDepurado ->setTitle("Datos metereologicos depurados");
		$hojaActual_excelDepurado->setCellValueByColumnAndRow(11, 1, "fila-insertada");
		$hojaActual_excelDepurado->setCellValueByColumnAndRow(12, 1, "contador-horas");
		$hojaActual_excelDepurado->setCellValueByColumnAndRow(13, 1, "RAIN depurada");
		$hojaActual_excelDepurado->setCellValueByColumnAndRow(14, 1, "RAIN RATE x0.1");	//dividido entre 10
		$hojaActual_excelDepurado->setCellValueByColumnAndRow(15, 1, "RAD.SOLAR x10");				


		/*==============================================================================================================================================================================
		=            RECORREMOS LAS CELDAS DEL ARCHIVO ESTACION HORIZONTALMENTE DE IZQUEIRDA A DERECHA, INICIANDO EN LA CELDA A2 Y AGREGAMOS LAS FILAS FALTANTES  EN EL NUEVO          =
		==============================================================================================================================================================================*/
				
		//iteramos en las celdas del documento cargado, atraves de sus filas y columnas
		for($fila = 2; $fila <= $maxFilas_documentoEstacion; $fila++)		
		{			
			//contamos las filas para luego comparar la cantidad de datos por dia con el numero de filas. Deben ser la misma cantidad. Es decir 24, de 0 a 23
			if($fila_excelDepurado >= 3)
			{
				$contador_horas++;
			}			

			//si el contador_horas llega a 24 se reinicia a 0
			if($contador_horas >= 24)
			{
				$contador_horas = 0;
			}		

			//Iniciamos el proceso en la primera columna. Con este for recorreremos todas las columnas de la fila correspondiente
			for($columna = 1; $columna <= $maxColumnas_documentoEstacion; $columna++)
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
						//aumentamos el valor de la variable, apra contar las filas insertadas.
						$contador_datos_agregados++;

						//obtengo la fecha del dato faltante
						$fechaAgregada_excelDepurado = $hojaActual_excelDepurado -> getCellByColumnAndRow(1, $fila_excelDepurado)-> getFormattedValue();											
						$datosAgregados_excelDepurado[$fila_excelDepurado] = $fechaAgregada_excelDepurado;	
										

						//En la celda que estamos creando, de la hora faltante, copiamos el dato de la celda de arriba
						$hojaActual_excelDepurado->setCellValueByColumnAndRow(11, $fila_excelDepurado, "X");

						//guardamos en la celda correspondiente el dato correcto guardado en contador_horas
						$hojaActual_excelDepurado->setCellValueByColumnAndRow($columna_excelDepurado, $fila_excelDepurado, $contador_horas);						
						$columna_excelDepurado++;
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
						$hojaActual_excelDepurado->setCellValueByColumnAndRow($columna_excelDepurado, $fila_excelDepurado, $valorAnterior);							
						$columna_excelDepurado++;					
					
					}			
									
				}				
				else 				
				{		

					//si el booleano no esta activo. Queire decir que los datos van bien , asi que los copiamos normalmente
					$hojaActual_excelDepurado->setCellValueByColumnAndRow($columna_excelDepurado, $fila_excelDepurado, $valorFormateado);		
						
					$columna_excelDepurado++;
					
					//esto apra que no me cambie el titulo de la columna en la fila 1, y solo guarde el contador un vez por fila
					if($fila >= 3 && $columna == 1)
					{
						//guardamos en una columna extra, los conteos de las horas hechos por contador_horas
						$hojaActual_excelDepurado->setCellValueByColumnAndRow(12, $fila_excelDepurado, $contador_horas);	
					}								

				}
			}

			//reiniciamos la variable columna_excelDepurado, que lleva el conteo de las columnas del nuevo excel generado
			$columna_excelDepurado = 1;
			$fila_excelDepurado++;
			
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
		=            CREAMOS COLUMNAS 13, 14 Y 15, APARTIR DE LA CORRECCION DE LAS COLUMNAS 8, 9 Y 10     =		
		=================================================================================================*/		

		//obtenemos el mayor numero de filas
		$maxFilas_excelDepurado = $hojaActual_excelDepurado -> getHighestRow();

		//iteramos en las filas del nuevo excel. Las columnas no por que son fijas
		for($fila = 2; $fila <= $maxFilas_excelDepurado; $fila++)
		{
			//9=H, 10=I, 11=J, 12=k, 13=L, 14=M, 15=N
			//H se copia en M
			//I se copia en N
			//J se copia en O		

			//obtenemos el valor indicada
			$valor_excelDepurado = $hojaActual_excelDepurado -> getCellByColumnAndRow(8, $fila) -> getFormattedValue();
		
			//si el valor es cero
			if($valor_excelDepurado == 0)
			{
				//se copia cero
				$hojaActual_excelDepurado ->setCellValueByColumnAndRow(13, $fila, '0');
			}
			elseif ($valor_excelDepurado > 0) 
			{
				//si es mayor a cero
				//buscamos el valor de la fila anterior
				$fila_previa = $fila -1;

				//consultamos la celda de arriba
				$valorPrevio_excelDepurado = $hojaActual_excelDepurado -> getCellByColumnAndRow(8, $fila_previa)-> getFormattedValue();				

				//si el valor de la celda de arriba es mayor a cero
				if($valorPrevio_excelDepurado > 0)
				{
					//en la celda actual, se copia cero
					$hojaActual_excelDepurado ->setCellValueByColumnAndRow(13, $fila, '0');
				}
				else
				{
					//se copia el valor tal cual venga
					$hojaActual_excelDepurado ->setCellValueByColumnAndRow(13, $fila, $valor_excelDepurado);
				}								
			}	
 			
 			//copiamos en las celdas 14 y 15, los datos de las celdas 9 y 10, con sus respectivas operaciones
			$hojaActual_excelDepurado ->setCellValueByColumnAndRow(14, $fila, '=I'.$fila.'/10'); 
			$hojaActual_excelDepurado ->setCellValueByColumnAndRow(15, $fila, '=J'.$fila.'*10'); 		

		}			


		/*==========================================================
		=            CENTRAMOS Y AJUSTAMOS LOS ESPACIOS            =
		==========================================================*/			

		$alineacion_excelDepurado = $hojaActual_excelDepurado -> getStyle('A1:Z'.$maxFilas_excelDepurado) -> getAlignment();		
		$alineacion_excelDepurado->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$letras = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O",);

		foreach ($letras as $value) 
		{
			$dimensionColumnas_excelDepurado = $hojaActual_excelDepurado -> getColumnDimension($value) ->setAutoSize(true);				
		}


		/*==================================================================================
		=            GUARDAMOS EL NUEVO ARCHIVO LUEGO DEL PROCESO DE DEPURACION            =
		==================================================================================*/

		$writer_excelDepurado = new Xls($excelDepurado);
		$writer_excelDepurado->save('../creados/Datos metereologicos depurados.xls');				

		$bandera_de_informacion = 100;			

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

<?php include "../Vistas/pagina_depurador.php";  ?>