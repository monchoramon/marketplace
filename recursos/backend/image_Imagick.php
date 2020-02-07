<?php

		// Tipo de contenido
		header('Content-Type: image/jpeg');

		// Fichero y nuevo tamaño
		$nombre_fichero = "../imagenes/trajes_de_bano/mujeres/teeee.jpg";
			$porcentaje = 0.5;

		// Obtener los nuevos tamaños
		list($ancho, $alto) = getimagesize($nombre_fichero);
			$nuevo_ancho = $ancho * $porcentaje;
				$nuevo_alto = $alto * $porcentaje;

		// Cargar
		$thumb = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
			$origen = imagecreatefromjpeg($nombre_fichero);

			// Cambiar el tamaño
			imagecopyresized($thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, 999, 686);

		// Imprimir
		imagejpeg($thumb, "../imagenes/trajes_de_bano/mujeres/ramon.jpg");

?>