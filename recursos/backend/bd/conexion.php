<?php


/**
 * by Ramón M.C
 */
class BD{
	public function conexion(){

		try {
			//brisa_de_mar
		    $BD = new PDO('mysql:host=localhost;dbname=brisamar;charset=utf8', 'root', '');
		    	return $BD;
		}catch (PDOException $e) {

		    print "No se pudo conectar a la BD => " . $e->getMessage() . "<br/>";
				die();

		}
	}
}

?>