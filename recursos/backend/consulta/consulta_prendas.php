<?php

	/**
	 * by Ramón M.C
	 */

		include_once '../bd/conexion.php';

	class consultas{
		
		public $conex;

		function __construct(){
			$BD = new BD();
				$this->conex = $BD->conexion();
		}

		function prendas(){

			$sql = $this->conex->prepare("SELECT id_prenda FROM prenda");
				$sql->execute();

				while ( $filas = $sql->fetch() ) {
					$id_prenda[] = $filas["id_prenda"];
				}

					if(@$id_prenda){

						$index_enti = 0;
							$entidades = array('talla', 'internacional', 'tela', 'precio', 'precio_anterior', 'colores', 'descripcion');

						foreach ($id_prenda as $key => $id) {

							$sql = $this->conex->prepare("SELECT id_prenda, talla, internacional, tela, precio, precio_anterior, colores, descripcion FROM prenda WHERE id_prenda = '$id';");
								$sql->execute();

							while ($fila = $sql->fetch()) {
								$info_prenda[] = $fila;
							}
						}
						
					}else{
						print_r(json_encode("No hay imagenes"));
					}

						if(@$info_prenda){

							foreach ($id_prenda as $key => $id) {

								$sql = $this->conex->prepare("SELECT id_prenda, url, nombre, likes FROM galeria WHERE id_prenda = '$id';");
									$sql->execute();

								while ( $filas = $sql->fetch() ) {
									$data_img[] = $filas;
								}
							}	
						}

				$index = 0;

				foreach (@$data_img as $key_b => $id_b) {
					foreach (@$info_prenda as $key_a => $id_a){
						if( $data_img[$key_b]["id_prenda"] === $info_prenda[$key_a]["id_prenda"] ){
							// print_r(json_encode( $info_prenda[$key_a]["id_prenda"] ));
							$info_prenda[$key_a]["img"][] = $id_b;
						}
					}

					$index = 0;
				}

			print_r(json_encode( @$info_prenda ));

			// $sql = $this->conex->prepare("SELECT prenda.id_prenda, prenda.talla, prenda.internacional, prenda.tela, prenda.precio, prenda.precio_anterior, prenda.colores, prenda.descripcion, galeria.url, galeria.nombre, galeria.likes FROM prenda INNER JOIN galeria ON galeria.id_prenda = prenda.id_prenda");

			// 		$sql->execute();

			// 		while ( $filas = $sql->fetch() ) {
			// 			$abc[] = $filas;
			// 		}
			

		}

	}

	$consultas = new consultas();
		$consultas->prendas();

?>