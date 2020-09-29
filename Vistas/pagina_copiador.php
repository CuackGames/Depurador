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
			<p class="text-white h4 py-2">ANALISIS COMPLETO</p>		
            <p class="text-white py-2"></p>	
		</span>

		<div >	

			<ul class="list-group pl-3 pr-3">			

				<!-- Nombre de documento analizado -->

				<li class="list-group-item">

					<div>
						<label><strong>Resultados </strong></label>
					</div>   

                    <!-- <div>                        
                        - <label><a href="../creados/Lago Alto 2019.xls" >Descargar archivo excel backup con los nuevos datos aqui</a></label>
                    </div>                  -->
                    
				</li>
			</ul>

		</div>	

		<div class="container pt-3">

			<button type="button" class="btn btn-default btn-light float-right " onclick="history.back()">Regresar</button>

		</div>

	</div>	    

</div>
	
</body>
</html>