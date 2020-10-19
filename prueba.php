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

    <div class="container mx-auto pt-5 " style="width: 200px; ">
        <a href="prueba2.php">
            <button id="boton_crear" type="button" class="btn btn-outline-primary bg-light " onclick="myFunction()">Crear</button>
        </a>
    </div>

</body>

</html>