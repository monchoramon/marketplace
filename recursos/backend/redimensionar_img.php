
<?php
	
	// header('Content-Type: image/jpeg');

	$org_info = getimagesize("../imagenes/trajes_de_bano/mujeres/aaaa.png");

		$rsr_org = imagecreatefrompng("../imagenes/trajes_de_bano/mujeres/kidj.png");
			$rsr_scl = imagescale($rsr_org, 405, 552, IMG_POWER);
				imagepng($rsr_scl, "../imagenes/trajes_de_bano/mujeres/kidj.png");//guardar directorio

					// $scl_info = getimagesize("imagebfb.jpg");
						imagedestroy($rsr_org);
							imagedestroy($rsr_scl);

	// $scl_info = getimagesize("imagebfb.jpg");
	// 	print_r(json_encode(  $scl_info[3] ));

?>

<img src="imagebfb.jpg" alt="imagebfb" /><br><br>