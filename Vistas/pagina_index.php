<div class="container">

	<div class="row">

		<form class="col-sm-12" method="POST" action="Controlador/depurador.php" enctype="multipart/form-data">

			<span>
				<p class="text-white h4 py-2">Depuradar datos</p>
				<p class="text-white py-2">Se carga el archivo excel descargado remotamente de la estacion Davis, y el archivo backUp de la estacion.</p>
			</span>

			<div>

				<ul class="list-group pl-3 pr-3">

					<li class="list-group-item">
						<div>
							<label><strong>Adjunte excel sin depurar, descargado de la estacion</strong></label>
						</div>
						<div>
							<input type="file" name="excel-estacion" id="excel-estacion" accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
						</div>
					</li>

					<li class="list-group-item">
						<div>
							<label><strong>Adjunte excel backup de la estacion</strong></label>
						</div>
						<div>
							<input type="file" name="excel-backup" id="excel-backup" accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
						</div>
					</li>

				</ul>

			</div>

			<div class="container pt-3 ">

				<button id="submit" type="submit" class="btn btn-default btn-light float-left">Depurar</button>

			</div>

		</form>

	</div>

</div>