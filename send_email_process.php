<?php

if ( !isset($_POST) || empty($_POST) ) {
	$status = array(
		'status'  => 'Error',
		'message' => '<p>Error! Not allowed.</p>'
	);
	echo json_encode($status);
	die();

	header("location: /404");
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
			'message' => '<p>Enter a valid name please.</p>',
		);
		die();
	}
	if ( !isset($email) || empty($email) ) {
		$status = array(
			'status'  => 'Error',
			'message' => '<p>Enter a valid email address please.</p>',
		);
		die();
	}
	if ( !isset($message) || empty($message) ) {
		$status = array(
			'status'  => 'Error',
			'message' => '<p>Enter a message please.</p>',
		);
		die();
	}
	// VALIDATION //

	$to = "your@email.com";
	$subject = "Your subject";

		$message = "
			<html>
				<head>
					<title>You have a new message</title>
				</head>
				<body>
					<p>Hi ".$to.",</p>
					<p>
						You have a new message!
					</p>
					<p>Message Details:</p>
					<p>
						From: ".$name."
						<br>
						<br>
						E-mail: ".$email."
						<br>
						<br>
						Phone: ".$phone."
						<br>
						<br>
						Message:
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
		$headers .= 'From: <no-reply@your-domain.com>' . "\r\n";
		//$headers .= 'Cc: email@dominio.com' . "\r\n";

		if ( mail($to,$subject, $message,$headers) ) {
			// SUCCESS MESSAGE --> EMAIL SENT
			$status = array(
				"status"  => 'success',
				"message" => 'Message sent with success!'
			);
			echo json_encode($status);
			die();

		} else {
			// ERROR MESSAGE --> EMAIL NOT SENT
			$status = array(
				"status"  => 'error',
				"message" => 'It was not possible to send your message!'
			);
			echo json_encode($status);
			die();
		}

} else {

	$status = array(
		'status'  => 'Error',
		'message' => '<p>Something went wrong! Message not sent! Please try again.</p>',
	);
	
	echo json_encode($status);
	die();
}

?>
