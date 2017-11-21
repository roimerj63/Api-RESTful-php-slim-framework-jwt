<?php

namespace lib;
use Firebase\JWT\JWT;

class Auth{
	

    protected $key = '154584asf435210sdf';

	public function setToken($data){
        $time = time(); // Tiempo que inició el token
        $timeExpired = $time+180; // Tiempo que expirará el token
        $dataUser = array( // información del usuario
                'id' => $data['id_user'],
                'name' => $data['nom_user'],
                'last_name' => $data['ape_user'],
                'user' => $data['usr_user'],
                'gender' => $data['gen_user'],
                'birth_date' => $data['nac_user'],
                'email' => $data['ema_user'],
                'rol' => $data['rol_user'],
                'estatus' => $data['sts_user']   
        );

        $dataToken = array('iat' => $time, 'exp' => $timeExpired, 'data_user' => $dataUser);
        $jwt = JWT::encode($dataToken, $this->key);

        Auth::setSesion(array('token' => $jwt, 'expired_session' => $timeExpired, 'data_user' => $dataUser));
        return $jwt;
    }

    public function verifyToken(){
    	$headers = apache_request_headers();
    	if(isset($headers['Authorization'])){
    		$token = $headers['Authorization'];
    		$verifySesion = Auth::verifySesion();
    		if($verifySesion['ID'] == '00'){
				if($_SESSION["data"]["token"] == $token){
            		$data = json_decode(json_encode(JWT::decode($token, $this->key, array('HS256'))), True);
    				$response = array('ID' => '00');
	    		}else{
					Auth::destroySesion();
	    			$response = array('ID' => '02', 'DESCRIPTION' => 'Token no valido');
	    		}
    		}else{
				$response = $verifySesion;
    		}
    	}else{
			Auth::destroySesion();
    		$response = array('ID' => '02', 'DESCRIPTION' => 'Transacción no permitida');
    	}

    	return $response;
    } 

    public function verifySesion(){
    	if (isset($_SESSION["data"]) && !empty($_SESSION['data'])) {
    		if($_SESSION["data"]["expired_session"]-time() > 0){
    			$response = array('ID' => '00', 'DESCRIPTION' => 'Posee sesion');
    		}else{
    			Auth::destroySesion();
    			$response = array('ID' => '01', 'DESCRIPTION' => 'Sesion ha expirado');
    		}	
    	}else{
    		$response = array('ID' => '01', 'DESCRIPTION' => 'No posee sesion');
    	}
    	return $response;
    }

    public function setSesion($data){
        $_SESSION["data"] = array();
        foreach ($data as $key => $value) {
            $_SESSION["data"][$key] = $value;
        }
    }

    public function destroySesion(){
        session_destroy();
        session_start();
    }

    public function decodeBase64($varDecode){
        $varDecode = base64_decode($varDecode);
        return $varDecode;
    }

}