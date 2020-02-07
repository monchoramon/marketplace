<?php

class conexion{

	public function conectardb(){
	    
	    $user = "root";
		$pass = "";
		$host = "localhost";
		$db   = "brisa_de_mar";
		
		$conex = new mysqli($host, $user, $pass, $db);
			mysqli_set_charset($conex, 'UTF8'); 
				setlocale(LC_TIME,"es_ES");

		if ($conex->connect_errno) {
			echo "Error de conexión!!";
				conexion::closeConex( $conex );
		}else{
		   return $conex;
		}
	
	}

	public function closeConex( $conex ){
		mysqli_close($conex);
		return $conex;
	}

}

?>