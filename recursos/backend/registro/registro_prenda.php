<?php

	include_once '../bd/conexion.php';

/**
 *by Ramón
 */

class guardar{

	public $file_img;
	public $directorio;
	public $conex;
	public $directorio_img;
	public $user_name;

	function __construct(){

		$this->file_img =  $_FILES["imagenes_prenda"];
			$this->user_name = 'registrox2'; // se crea la carpeta principal con este nombre, despues se crean las subcarpetas.
				$this->directorio_root = $_SERVER['DOCUMENT_ROOT'].'/trajes_banos/uploaded_image/';
					$this->directorio = $_SERVER['DOCUMENT_ROOT'].'/trajes_banos/uploaded_image/'.$this->user_name.'/';
							$BD = new BD();
							$this->conex = $BD->conexion();
								$this->directorio_img = null;

	}


		function validar_directorio(){

			$mkdir = '../../../uploaded_image/'.$this->user_name;

			if( file_exists($mkdir) ) {
			    guardar::validar_tipos();
			}else{
			   	guardar::create_dir_personal();
			}

		}

			function validar_tipos(){

				$tipos_img = array("image/jpeg", "image/jpg", "image/png");
					$ctn_formato = 0;

				foreach ($this->file_img["type"] as $key => $img_entrada) {
					foreach ($tipos_img as $key => $tipos_aceptados) {
						if($img_entrada === $tipos_aceptados){
							$ctn_formato++;
						}
					}
				}

				if( $ctn_formato === sizeof($this->file_img["name"]) ){
					guardar::image_save();
				}else{
					print_r(json_encode(array('tipe'=>11, 'info'=>"El tipo de formato no corresponde al de una imagen o no a seleccionada ninguna.")));
				}

			}

			function image_save(){

					@$persona = $_POST["persona"];
						@$tipo_pieza = $_POST["tipo_pieza"];

				/*print_r(json_encode( array( $persona, $sola_pieza ) ));*/

				switch( $persona ) {

					case 0:
						$directorio_final = guardar::directorio_final($persona, $tipo_pieza);
					break;
					
						case 1:
							$directorio_final = guardar::directorio_final($persona, $tipo_pieza);
						break;

					default:
						print_r(json_encode(array('tipe'=>17, 'info'=>"Tipo de persona incorrecta.")));
					break;
				}

					if( $directorio_final ){
						if( guardar::validar_vacios() ){
							if( guardar::save_prenda_info() ){
								guardar::save_img( $directorio_final );
							}else{
								print_r(json_encode(array('tipe'=>18, 'info'=>"Algo internamente sucedio.")));
							}
						}
					}else{
						print_r(json_encode(array('tipe'=>12, 'info'=>"No a seleccionado ninguna imagen.")));
					}

			}


				function directorio_final( $persona, $tipo_pieza ){

					if( $persona ){
						$tipo_persona = 'dama';
					}else{
						$tipo_persona = 'nina';
					}

						switch( $tipo_pieza ){

							case 0:
								$directorio_final = $this->directorio."$tipo_persona/completo/";
									$this->directorio_img = "../uploaded_image/".$this->user_name."/$tipo_persona/completo/"; //sustituir $this->user_name por correo o variable session.
							break;

								case 1:
									$directorio_final = $this->directorio."$tipo_persona/dos_piezas/";
										$this->directorio_img = "../uploaded_image/".$this->user_name."/$tipo_persona/dos_piezas/"; //sustituir $this->user_name por correo o variable session.
								break;

							default:
								print_r(json_encode(array('tipe'=>13, 'info'=>"No a seleccionada una persona y/o tipo de traje de baño adecuados.")));
							break;

						}

					if( @$directorio_final ){
						return @$directorio_final;
					}

				}

			function save_img( $directorio_final ){

				$file_save = 0;
					$name_img = $this->file_img["name"];

				foreach ($name_img as $key => $name){

					$tmp_name = $this->file_img["tmp_name"][$key];					
						$type = $this->file_img["type"][$key];

					if(	move_uploaded_file( $tmp_name, $directorio_final.$name ) ){
						guardar::save_dat_img($name, $type, $directorio_final, sizeof($name_img), $key);
							$file_save++;
					}

				}

					if( $file_save != sizeof($name_img) ){
						print_r(json_encode(array('tipe'=>14, 'info'=>"Algunas de las imagenes no se pudieron guardar en el directorio correspondiente.")));
					}

			}


				function save_prenda_info(){

						$datos_entrada = guardar::datos_entrada();
							$tipe = false;
								$sql = $this->conex->prepare("INSERT INTO prenda(descripcion, talla, internacional, colores, tela, precio, precio_anterior, categoria_persona, categoria_tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
							
							// $sql->bindParam(1, $des_extra);
							// $sql->bindParam(2, $talla);
							// $sql->bindParam(3, $internacional);
							// $sql->bindParam(4, $colores_prenda);
							// $sql->bindParam(5, $tela);
							// $sql->bindParam(6, $precio);
							// $sql->bindParam(7, $precio_anterior);
							// $sql->bindParam(8, $persona);
							// $sql->bindParam(9, $tipo_pieza);

							$sql->bindParam(1, $datos_entrada[0]);
							$sql->bindParam(2, $datos_entrada[1]);
							$sql->bindParam(3, $datos_entrada[2]);
							$sql->bindParam(4, $datos_entrada[3]);
							$sql->bindParam(5, $datos_entrada[4]);
							$sql->bindParam(6, $datos_entrada[5]);
							$sql->bindParam(7, $datos_entrada[6]);
							$sql->bindParam(8, $datos_entrada[7]);
							$sql->bindParam(9, $datos_entrada[8]);

							if( $sql->execute() ){
								$tipe = true;
							}

						return $tipe;
				}


					function validar_vacios(){

						$datos_entrada = guardar::datos_entrada();
							$vacios = 0;

						foreach ($datos_entrada as $key => $value) {
							if( empty(trim($value)) && ($key != 7 && $key != 8) ){
								$vacios++;
							}

						}

							if($vacios === 0){
								return true;
							}else{
								print_r(json_encode(array('tipe'=>17, 'info'=>"Necesita llenar todos los campos y seleccionar el tipo de categoria.")));
							}


					}


						function datos_entrada(){

							@$des_extra = $_POST["des_extra"];
							@$talla = $_POST["talla"];
							@$internacional = $_POST["internacional"];
							@$colores_prenda = $_POST["colores_prenda"];
							@$tela = $_POST["tela"];
							@$precio = $_POST["precio"];
							@$precio_anterior = $_POST["precio_anterior"];
							@$persona = $_POST["persona"];
							@$tipo_pieza = $_POST["tipo_pieza"];

							$valores = array(@$des_extra, @$talla, @$internacional, @$colores_prenda, @$tela, @$precio, @$precio_anterior, @$persona, @$tipo_pieza);

								return $valores;
						}


					function save_dat_img( $name, $type, $directorio_final, $long_items, $key ){

						// '../uploaded_image/

						$sql = $this->conex->prepare("SELECT MAX(id_prenda) id_maximo FROM prenda");
							$sql->execute();
								while($filas = $sql->fetch() ) {
									$max_val[] = $filas;
								}

									$id_max = $max_val[0]["id_maximo"];

								$sql = $this->conex->prepare("INSERT INTO galeria(id_prenda, dir_personal, url, nombre, tipo) VALUES (?, ?, ?, ?, ?)");

									$sql->bindParam(1, $id_max);
									$sql->bindParam(2, $dir_personal);
									$sql->bindParam(3, $this->directorio_img);
									$sql->bindParam(4, $name);
									$sql->bindParam(5, $type);

										$sql->execute();

							if( $long_items == ($key+1) ){
								print_r(json_encode(array('tipe'=>1, 'info'=>"Registro generado correctamente.")));
							}
							

					}


		function create_dir_personal(){

		 	// $this->user_name sustituir por variable de sesión
				$tipe = false;

			if( @mkdir($this->directorio_root.$this->user_name, 0700, true) ){
				guardar::create_sub_dir_a();
			}else{
				print_r(json_encode(array('tipe'=>15, 'info'=>"No fue posible crear el directorio personal.")));
			}

		}

			function create_sub_dir_a(){

				$persona = array('dama', 'nina');

					$i = 0;
						$completos = 0;

					while( $i != 2){
						if( @mkdir($this->directorio_root.$this->user_name."/".$persona[$i], 0700, true) ){
							$completos++;
						}
						$i++;
					}

				if( $completos === 2){
					guardar::create_sub_dir_b();
				}

			}

				function create_sub_dir_b(){

					$persona = array('dama', 'nina');
						$prenda = array('completo', 'dos_piezas');
		 					$completos = 0;

						for($x = 0; $x < 2; $x++){
							for($y = 0; $y < 2; $y++){
								if( @mkdir($this->directorio_root.$this->user_name."/".$persona[$x]."/".$prenda[$y], 0700, true) ){
									$completos++;
								}
							}
						}

					if( $completos === 4){
					    guardar::validar_tipos();
					}else{
						print_r(json_encode(array('tipe'=>16, 'info'=>"No fue posible crear los directorios finales internos.")));
					}

				}// funcion



}

	$guardar = new guardar();
		$guardar->validar_directorio();//validar_directorio

		/*if( move_uploaded_file( $_FILES["imagenes_prenda"]["tmp_name"][0], $directorio.$_FILES["imagenes_prenda"]["name"][0] ) ){
				rename($directorio.$_FILES["imagenes_prenda"]["name"][0], $directorio."rtm-bra".'.'.explode( '/', $_FILES["imagenes_prenda"]["type"][0] )[1]);
					print_r(json_encode( $_FILES["imagenes_prenda"] ));
		}else{
			print_r(json_encode($directorio));
		}*/

?>