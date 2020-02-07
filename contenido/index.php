<!DOCTYPE html>
<html>
<head>
	<title>Agregar nuevo contenido</title>
	<?php include_once '../index/header_index.php'; ?>
</head>
<body>
	<?php include_once '../index/main.html'; ?>

	<section id="content_tra">

		<form id="info_prenda" enctype="multipart/form-data">

			<article id="seleccion_img">
				<label>Seleccione las imagenes necesarias para su registro: </label>
					<input type="file" id="imagenes_prenda" name="imagenes_prenda[]" multiple>
			</article>

			<article id="img_seleccionadas"></article>

			<article id="cont_talla">

				<div id="talla">		
					<div class="content">
						<label>Talla:</label>
						<input type="text" name="talla" placeholder="32">
					</div>
					<div class="content">
						<label>Internacional:</label>
						<input type="text" name="internacional" placeholder="S">
					</div>
				</div>

				<div class="content">
					<label>Tela:</label>
					<input type="text" name="tela" placeholder="Algodón fino">
				</div>

				<div class="content">
					<label>Precio:</label>
					<input type="text" name="precio" placeholder="$400">
				</div>

				<div class="content">
					<label>Precio anterior:</label>
					<input type="text" name="precio_anterior" placeholder="$400">
				</div>

				<div class="content">
					<label>Colores:</label>
					<div>
						<textarea name="colores_prenda" placeholder="Azul, rojo, verde, rosa y marron">
						</textarea>
					</div>
				</div>

				<div class="content">
					<label>Descripción extra:</label>
					<div>
						<textarea name="des_extra" placeholder="El traje de baño es barato...">
						</textarea>
					</div>
				</div>

				<div class="content">

					<label>Categoria:</label>

					<div id="categoria_persona">
						<div>
							<label>Niña</label>
							<input type="radio" name="persona" value="0">
						</div>

						<div>
							<label>Mujer</label>
							<input type="radio" name="persona" value="1">
						</div>
					</div>

					<div id="categoria_persona">
						<div>
							<label>Completo</label>
							<input type="radio" name="tipo_pieza" value="0">
						</div>
						<div>
							<label>2 piezas</label>
							<input type="radio" name="tipo_pieza" value="1">
						</div>
					</div>

				</div>

				<button type="submit" id="registrar">Guardar</button>

			</article>

		</form>

	</section>

</body>

	<?php include_once '../index/footer_index.php' ?>

</html>