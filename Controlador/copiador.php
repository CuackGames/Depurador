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
	$horaAgregada_excelDepurado = 0;
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
		$nombre_archivoBackup = $_FILES['excel-backup']['name'];	

		//El nombre temporal del fichero en el cual se almacenan los ficheros subidos en el servidor.		
		$tmp_archivoBackup = $_FILES['excel-backup']['tmp_name'];

		/*====================================================================
		=            MOVEMOS EL ARCHIVO A LA CARPETA DEL PROYECTO            =
		====================================================================*/ 
			
		move_uploaded_file($tmp_archivoBackup, "../cargados/$nombre_archivoBackup" );
		
		/*=============================================================================================
		=            CARGAMOS EL ARCHIVO ESTACION, OBTENEMOS EL NUMERO DE FILAS Y COLUMNAS            =
		=============================================================================================*/

		//cargamos los documentos cargados
        $documentoBackup = IOFactory::load("../cargados/$nombre_archivoBackup");
        $documentoDepurado = IOFactory::load("../creados/Datos metereologicos depurados.xls");

		//obtenemos la primera hoja de cada documento		
		$hojaActual_documentoBackup = $documentoBackup -> getSheetByName("ORIGINAL");			
        $hojaActual_excelDepurado = $documentoDepurado -> getSheet(0);

        //maximo filas excel depurado
        $maxFilas_excelDepurado = $hojaActual_excelDepurado -> getHighestRow();;

		/*=====================================================================
		=            INSERTANDO INFORMACION EN EL DOCUMENTO BACKUP            =
		=====================================================================*/

		$maxFilas_documentoBackup = $hojaActual_documentoBackup -> getHighestRow();
		$filaObjetivo_documentoBackup = 0;		
		
		for($fila = 1; $fila <= $maxFilas_documentoBackup; $fila++)
		{					
			$datoFecha_documentoBackup = $hojaActual_documentoBackup -> getCellByColumnAndRow(1, $fila) -> getFormattedValue();
			$primerDato_excelDepurado = $hojaActual_excelDepurado -> getCellByColumnAndRow(1, 2) -> getFormattedValue(); 

			if($datoFecha_documentoBackup == $primerDato_excelDepurado)
			{
				$filaObjetivo_documentoBackup = $fila;				
				break;
			}
		}

		$filas_excelDepurado = 1;
		$total_filas_a_copiar = $filaObjetivo_documentoBackup + $maxFilas_excelDepurado;
		
		for($fila = $filaObjetivo_documentoBackup; $fila <= $total_filas_a_copiar; $fila++)
		{
			$filas_excelDepurado++;

			///excelDepurado-columna3-temp, se copia en, excelBackup-columna8-tempOut
			$datoTemp_excelDepurado = $hojaActual_excelDepurado -> getCellByColumnAndRow(3, $filas_excelDepurado) -> getFormattedValue();
			$hojaActual_documentoBackup -> setCellValueByColumnAndRow(8, $fila, $datoTemp_excelDepurado);			
			
			//en excelBackup-columna9-hiTemp y en excelBackup-columna10-lowTemp, se copia -999
			$hojaActual_documentoBackup -> setCellValueByColumnAndRow(9, $fila, '-999');
			$hojaActual_documentoBackup -> setCellValueByColumnAndRow(10, $fila, '-999');

			//excelDepurado-columna4-humedad, se copia en excelBackup-columna11-outHum
			$datoHumedad_excelDepurado = $hojaActual_excelDepurado -> getCellByColumnAndRow(4, $filas_excelDepurado) -> getFormattedValue();
			$hojaActual_documentoBackup -> setCellValueByColumnAndRow(11, $fila, $datoHumedad_excelDepurado);

			//en excelBackup-columna12-dewPt, se copia -999
			$hojaActual_documentoBackup -> setCellValueByColumnAndRow(12, $fila, '-999');

			//excelDepurado-columna5-v:v, se copia en excelBackup-columna13-windSpeed
			$datoVV_excelDepurado  = $hojaActual_excelDepurado -> getCellByColumnAndRow(5, $filas_excelDepurado) -> getFormattedValue();
			$hojaActual_documentoBackup -> setCellValueByColumnAndRow(13, $fila, $datoVV_excelDepurado);

			//excelDepurado-columna6-D:V, se copia en excelBackup-columna14-windDir
			$datoDV_excelDepurado  = $hojaActual_excelDepurado -> getCellByColumnAndRow(6, $filas_excelDepurado) -> getFormattedValue();
			$hojaActual_documentoBackup -> setCellValueByColumnAndRow(14, $fila, $datoDV_excelDepurado);

			//excelBackup-columnas-13(WindRun)-14(HiSpeed)-15(HiDir)-16(WindChill)
			$hojaActual_documentoBackup -> setCellValueByColumnAndRow(13, $fila, '-999');
			$hojaActual_documentoBackup -> setCellValueByColumnAndRow(14, $fila, '-999');
			$hojaActual_documentoBackup -> setCellValueByColumnAndRow(15, $fila, '-999');
			$hojaActual_documentoBackup -> setCellValueByColumnAndRow(16, $fila, '-999');

		}

		/*==================================================================================
		=            GUARDAMOS EL NUEVO ARCHIVO LUEGO DEL PROCESO DE DEPURACION            =
		==================================================================================*/
		
		$writer_excelBackup = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($documentoBackup, 'Xls');
		$writer_excelBackup->save('../creados/Lago Alto 2019.xls');
				

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

<?php include "../Vistas/pagina_copiador.php";  ?>