<?php
require_once(dirname(__FILE__) . '/../init.php');

$alert = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$response = $_POST['g-recaptcha-response'];
	$alert = array();

	if (\Recaptcha\Recaptcha::validate($response, '6Ldt3x4UAAAAAJ90azpRQkzsEBV43tObtVnmXdht')) {

		$alert['class'] = 'alert-success';
		$alert['text']  = 'The captcha was solved <b>correctly</b>!';

	} else {

		$alert['class'] = 'alert-danger';
		$alert['text']  = 'The captcha was resolved <b>incorrectly</b>!';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Recpatcha Invisible</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://www.google.com/recaptcha/api.js"></script>
		<script>
       	function onSubmit(token) {
        	document.getElementById("form").submit();
    	}
	    </script>
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h1>Google reCAPTCHA <small>INVISIBLE</small></h1>
			</div>
			<form id="form" method="post">

				<?php if($alert): ?>

				<div class="alert <?=$alert['class']?>" role="alert">
					<?=$alert['text']?>
				</div>

				<?php endif; ?>

				<button type="submit" class="btn btn-primary g-recaptcha" data-callback="onSubmit" data-sitekey="6Ldt3x4UAAAAACEn41FvRv1yCc653YMyGXoXoHWP">
					Submit
				</button>

			</form>
		</div>
	</body>
</html>