<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <!-- Bootstrap 4 is mobile-first -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,300;1,900&display=swap" rel="stylesheet">

    <!-- css -->    
    <link rel="stylesheet" type="text/css" href="css/main.css" />

    <!-- js -->
    <script src="js/main.js"></script>

</head>

<body class="bg-dark">

    <div id="contenedor_carga">
        <div id="carga"></div>
        <div class="container">
            <div class="row justify-content-center align-items-center minh">
                <div class="col-lg-12">                    
                    <div>
                        <p class="text-white text-center titulo-carga">Analizando...</p>
                    </div> 
                    <div>
                        <p class="text-white text-center cuerpo-carga">Espera, esto puede tardar unos minutos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>

        <p class="text-white">

            <?php

            /* ============================================================================================================ */

            //llama al autoload
            require 'vendor/autoload.php';

            //carga la clase PhpSpreadsheet usando nameSpaces
            use PhpOffice\PhpSpreadsheet\Spreadsheet;

            use PhpOffice\PhpSpreadsheet\IOFactory;

            //llama a la clase writer/xlsx para crear el archivo xlsx
            use PhpOffice\PhpSpreadsheet\Writer\Xls;

            set_time_limit(500);

            /* ============================================================================================================ */

            $start =  microtime(true);
            echo $start . '<br>';

            /* ============================================================================================================ */

            //crear un nuevo objeto de la clase spreadsheet. para el nuevo doc. excel
            $excelDepurado = new Spreadsheet();

            //obtiene la hoja activa actual(primera hoja). para el nuevo doc excel.
            $hojaActual_excelDepurado = $excelDepurado->getActiveSheet();

            //titulo de la hoja
            $hojaActual_excelDepurado->setTitle("prueba");

            //recorremos el excel backup, para copiar los datos del escel depurado, iniciando en la fila encontrada. hasta el total de filas indicado
            for ($fila = 1; $fila <= 10000; $fila++) {
                for ($i = 0; $i < 100; $i++) {
                    $hojaActual_excelDepurado->setCellValueByColumnAndRow($i, $fila, 'Diego' . $fila);
                }
            }

            $writer_excelDepurado = new Xls($excelDepurado);
            $writer_excelDepurado->save("creados/prueba.xls");

            /* ============================================================================================================ */

            $end = microtime(true);
            echo $end . '<br>';
            echo round($end - $start, 2) . ' segundos';

            ?>

        </p>

    </div>

</body>

</html>