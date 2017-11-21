<?php

// LOGIN POST - USER AND PASSWORD
$app->post('/login', function () use ($app) {
	$userModel =  new models\User();
	$auth =  new lib\Auth();
	$sesion =  $auth->verifySesion(); #Verifica si el usuario posee sesión
	if($sesion['ID'] != '00'){ 
		$data = json_decode($app->request()->post('data'), true);
		$email = $data['user'];
		$pass = hash("sha1", $data['pass']);
		$responseLogin = $userModel->login($email, $pass); #Procede a consultar el usuario
		if($responseLogin['ID'] == '00'){
			$token = $auth->setToken($responseLogin['DATA'][0]); # Asigna token y sesión al usuario  
			$responseFinal = array('ID'=> '00', 'TOKEN' => $token);
		}else{
			$responseFinal = $responseLogin;
		}
	}else{
		$responseFinal = array('ID'=> '01', 'DESCRIPTION' => 'Estimado usuario, usted ya posee una sesión activa.');
	}
	$app->contentType('application/json');
	echo json_encode($responseFinal);
});

// Get user
$app->get('/users/:user', function($user) use ($app) {
	$auth =  new lib\Auth();
	$userModel =  new models\User();
	$verifyToken = $auth->verifyToken();
	if($verifyToken['ID'] == '00'){
		$user = $auth->decodeBase64($user);
		$filter = array('usr_user'=>$user);
		$fields = 'usr_user, nom_user, ape_user';
		$responseFinal = $userModel->getUsers($fields,$filter);
	}else{
		$responseFinal = $verifyToken;
	}
	$app->contentType('application/json');
	echo json_encode($responseFinal);
});

//Create user
$app->post('/user', function () use ($app) {
	$userModel =  new models\User();
	$auth =  new lib\Auth();

	$verifyToken = $auth->verifyToken();
	if($verifyToken['ID'] == '00'){
		$data = json_decode($app->request()->post('data'), true);	
		$fields = array(
			"usr_user" => $data['user'],
			"nom_user" => $data['nom'],
			"ape_user" => $data['ape'],
			"pass_user" =>  hash("sha1", $data['pass']),
			"gen_user" => $data['gen'],
			"nac_user" => $data['nac'],
			"ema_user" => $data['ema'],
			"rol_user" => $data['rol'],
			"sts_user" => $data['sts'],
		);
		$responseFinal = $userModel->insertUser($fields);
	}else{
		$responseFinal = $verifyToken;
	}
	$app->contentType('application/json');
	echo json_encode($responseFinal);
});

// Update user
$app->put('/user', function() use ($app) {	
	$userModel =  new models\User();
	$auth =  new lib\Auth();

	$verifyToken = $auth->verifyToken();
	if($verifyToken['ID'] == '00'){
		$data = json_decode($app->request()->put('data'), true);
		$filter = array('usr_user' => $data['user']);
		$fields = array(
			'nom_user' => $data['nom'],
			'ape_user' => $data['ape'],
			'pass_user' => hash("sha1", $data['pass']),
			'gen_user' => $data['gen'],
			'nac_user' => $data['nac'],
			'ema_user' => $data['ema'],
			'rol_user' => $data['rol'],
			'sts_user' => $data['sts']
		);
		$responseFinal = $userModel->updateUser($fields, $filter);
	}else{
		$responseFinal = $verifyToken;
	}

	$app->contentType('application/json');
	echo json_encode($responseFinal);
});

// Delete user
$app->delete('/user', function() use ($app) {	
	$userModel =  new models\User();
	$auth =  new lib\Auth();

	$verifyToken = $auth->verifyToken();
	if($verifyToken['ID'] == '00'){
		$data = json_decode($app->request()->post('data'), true);
		$filter = array('usr_user' => $data['user']);
		$responseFinal = $userModel->deleteUser($filter);
	}else{
		$responseFinal = $verifyToken;
	}

	$app->contentType('application/json');
	echo json_encode($responseFinal);
});

