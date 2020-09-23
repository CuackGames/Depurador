<div class="container">

	<form method="POST" action="Controlador/depurador.php" enctype="multipart/form-data">

		<span>
			<p class="text-white h4 py-2">Archivos fuente para trabajar</p>		
		</span>
  
		<div >	

			<ul class="list-group pl-3 pr-3">

				<li class="list-group-item">
					<div >
						<label><strong>Excel sin depurar de la estacion</strong></label>
					</div>
					<div>
						<input type="file" name="excel-estacion" id="excel-estacion" accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" >
					</div>
				</li>

				<li class="list-group-item">
					<div>
						<label><strong>Excel backup de la estacion</strong></label>
					</div>
					<div>
						<input type="file" name="excel-backup" id="excel-backup" accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" >
					</div>
				</li>					

			</ul>

		</div>

		<div class="container pt-3 ">

			<button id="submit" type="submit" class="btn btn-default btn-light float-left">Analizar</button>

		</div>

	</form>

</div>

