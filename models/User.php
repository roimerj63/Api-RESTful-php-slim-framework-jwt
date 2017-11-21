<?php

/**
 * This is an example of User Class using PDO
 *
 */

namespace models;
use lib\Core;
use PDO;

class User {

	protected $core;

	function __construct() {
		$this->core = Core::getInstance();
		//$this->core->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function login($email, $pass) {
		$filter = array('usr_user' => $email); //name field db, value
		$consulta = Core::processConsult("user", "*", $filter);
		if(sizeof($consulta) > 0){
			if($consulta[0]['pass_user'] === $pass){
				if($consulta[0]['sts_user'] === '1'){
					$response = array('ID'=> '00', 'DATA' => $consulta);
				}else{
					$response = array('ID'=> '01', 'DESCRIPTION'=> 'Usuario con estatus inactivo, contácte con el administrador.');
				}
			}else{
				$response = array('ID'=> '01', 'DESCRIPTION'=> 'Usuario o contraseña no coinciden.');
			}
		}else{
			$response = array('ID'=> '01', 'DESCRIPTION'=> 'No se encontraron datos.');
		}
		return $response;
	}

	public function insertUser($fieldsValue) {
		$responseSQL = Core::processInsert("user", $fieldsValue);
		if(sizeof($responseSQL) > 0){
			$response = array( 'ID' => '00', 'DESCRIPTION' => 'Solicitud procesada con éxito');
		}else{
			$checkUser = User::getUsers("*", array('usr_user' => $fieldsValue['usr_user']));
			if($checkUser['ID'] == '00'){
				$response = array( 'ID' => '01', 'DESCRIPTION' => 'Este usuario ya se encuentra en uso.');
			}else{
				$response = array( 'ID' => '02', 'DESCRIPTION' => 'No se pudo procesar la solicitud');
			}
		}

		return $response;
	}

	public function getUsers($fields = "*", $filter = array()) {
		if($_SESSION["data"]["data_user"]['rol'] == 1){
			$consulta = Core::processConsult("user", $fields, $filter);
			if(sizeof($consulta) > 0){
				$response = array( 'ID' => '00', 'DESCRIPTION' => 'Solicitud procesada con éxito', 'DATA'=> $consulta);
			}else{
				$response = array( 'ID' => '01', 'DESCRIPTION' => 'No se encontraron datos');
			}
		}else{
			$response = array( 'ID' => '02', 'DESCRIPTION' => 'Solicitud no permitida');
		}
    	return $response;
	}

	public function updateUser($fields, $filter){
		$response = Core::processUpdate("user", $fields, $filter);
		if(sizeof($response) > 0){
			$response = array( 'ID' => '00', 'DESCRIPTION' => 'Solicitud procesada con éxito');
		}else{
			$response = array( 'ID' => '01', 'DESCRIPTION' => 'No se pudo procesar la transacción');
		}
		return $response;
	}

	public function deleteUser($filter){
		if($_SESSION['data']['data_user']['rol'] == 1){
			$response = Core::processDelete('user', $filter);
			if(sizeof($response) > 0){
				$response = array( 'ID' => '00', 'DESCRIPTION' => 'Solicitud procesada con éxito');
			}else{
				$response = array( 'ID' => '01', 'DESCRIPTION' => 'No se pudo procesar la transacción');
			}
		}else{
			$response = array( 'ID' => '02', 'DESCRIPTION' => 'Transacción no permitida');
		}
    	
    	return $response;
	}

	// {"user":"avelasquez", "nom":"Andres", "ape":"Velasquez", "pass":"123", "gen":"M", "nac":"1995-11-07", "ema":"roimer_7@hotmail.com", "rol": "1", "sts":"1"}

}