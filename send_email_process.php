<?php

if ( !isset($_POST) || empty($_POST) ) {
	$status = array(
		'status'  => 'Error',
		'message' => '<p>Ocorreu um erro inesperado! Acesso não permitido! Tente novamente por favor.</p>'
	);
	echo json_encode($status);
	die();

	header("location: 404");
	die();
}

//echo json_encode($_POST);
//die();

if ( isset($_POST['action']) && $_POST['action'] == 'Send Email To Business Owner') {

	function sanitizeSimple($data) {
		$data = trim($data);
		$data = htmlspecialchars(strip_tags($data));
		return $data;
	}

	function sanitizeEmail($data) {
		$data = preg_replace('/\s+/', '', $data);
		$data = strtolower($data);
		$data = htmlspecialchars(strip_tags($data));
		if ( filter_var($data, FILTER_VALIDATE_EMAIL)) {
			return $data;
		} else {
			return false;
		}
	}

	$name    = sanitizeSimple($_POST['name']);
	$phone   = sanitizeSimple($_POST['phone']);
	$email   = sanitizeEmail($_POST['email']);
	$message = sanitizeSimple($_POST['message']);

	// VALIDATION //
	if ( !isset($name) || empty($name) ) {
		$status = array(
			'status'  => 'Error',
			'message' => '<p>Insira um nome válido, por favor.</p>',
		);
		die();
	}
	if ( !isset($email) || empty($email) ) {
		$status = array(
			'status'  => 'Error',
			'message' => '<p>Insira um endereço de e-mail válido, por favor.</p>',
		);
		die();
	}
	if ( !isset($message) || empty($message) ) {
		$status = array(
			'status'  => 'Error',
			'message' => '<p>Insira uma mensagem válida, por favor.</p>',
		);
		die();
	}
	// VALIDATION //

	$to = "your@email.com";
	$subject = "Your subject title";

		$message = "
			<html>
				<head>
					<title>Recebeu uma nova mensagem</title>
				</head>
				<body>
					<p>Olá ".$to.",</p>
					<p>
						Recebeu uma nova mensagem através do formulário de contacto existente no seu website Ok Eu Resolvo!
					</p>
					<p>Dados da Mensagem:</p>
					<p>
						De: ".$name."
						<br>
						<br>
						E-mail: ".$email."
						<br>
						<br>
						Telefone: ".$phone."
						<br>
						<br>
						Mensagem:
						<br>
						".nl2br($message)."
					</p>
				</body>
			</html>
		";

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: no-reply@your-website-domain-name.com' . "\r\n";
		//$headers .= 'Cc: email@dominio.com' . "\r\n";

		if ( mail($to,$message,$headers) ) {
			// SUCCESS MESSAGE --> EMAIL SENT
			$status = array(
				"status"  => 'success',
				"message" => 'Obrigado por nos contactar. Tentaremos responder o mais breve possível. Obrigado.'
			);
			echo json_encode($status);
			die();

		} else {
			// ERROR MESSAGE --> EMAIL NOT SENT
			$status = array(
				"status"  => 'error',
				"message" => 'Foi detetado um erro inesperado! Atualize a página e tente novamente, por favor.'
			);
			echo json_encode($status);
			die();
		}

} else {

	$status = array(
		'status'  => 'Error',
		'message' => '<p>Ocorreu um erro inesperado! Tente novamente por favor.</p>',
	);
	
	echo json_encode($status);
	die();
}

?>