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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>

    <style>
        *,
        *:after,
        *:before {
            margin: 0;
            padding: 0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        #contenedor_carga {
            background-color: rgba(250, 240, 245, 1);
            height: 100%;
            width: 100%;
            position: fixed;
            -webkit-transition: all 1s ease;
            -o-transition: all 1s ease;
            transition: all 1s ease;
            z-index: 10000;
        }

        #carga {
            border: 15px solid #ccc;
            border-top-color: #1b84ca;
            border-top-style: groove;
            height: 100px;
            width: 100px;
            border-radius: 100%;

            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            -webkit-animation: girar 1.5s linear infinite;
            -o-animation: girar 1.5s linear infinite;
            animation: girar 1.5s linear infinite;
        }

        @keyframes girar {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <div id="contenedor_carga">
        <div id="carga"></div>
    </div>

    <div class="container mx-auto pt-5" style="width: 200px; ">
        <a href="prueba2.php">
            <button id="boton_crear" type="button" class="btn btn-outline-primary" onclick="myFunction()">Crear</button>
        </a>
    </div>


    <script>
        
        function myFunction() {
            // document.getElementById('boton_crear').disabled = false;
            var contenedor = document.getElementById('contenedor_carga');
            contenedor.style.visibility = 'visible ';
            contenedor.style.opacity = '1';

        }

        window.onload = function() {
            var contenedor = document.getElementById('contenedor_carga');
            contenedor.style.visibility = 'hidden';
            contenedor.style.opacity = '0';
        }
    </script>

</body>

</html>