
<?php     

require '../vendor/autoload.php';
 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


    if (isset($_GET['dato1'])) 
    {
    	$dato1 = $_GET['dato1'];    	

        DescargarArchivoExcel($dato1);
    }

    function DescargarArchivoExcel($dato1)
	{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Datos metereologicos depurados.xls"');
		
        $writer = IOFactory::createWriter($dato1, 'Xls');
		$writer->save('php://output');
        exit;
	}

?>




