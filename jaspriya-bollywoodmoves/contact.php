<?php

/*
 * This function returns null if arg does not match the pattern (only texts).
 * Otherwise it returns the arg.
 */
function testInput($input_text, $pattern) {
	if (!preg_match($pattern, $input_text)) {
		return null;
	} else {
		return $input_text;
	}
}

/*
 * show use of array, loop and string
 */
function validateComment($arg_msg) {
	global $msg, $msgErr;
	
	$msgErr = "";
	$trim_msg = trim($arg_msg);
	$len = strlen($trim_msg);
	if ($len == 0) {
		$msgErr = "Comment should have some words";
	} else {
		$words = explode(" ", $trim_msg);
		$len = count($words);
		for ($i = 0; $i < $len; $i++) {
			if (strlen($words[$i]) > 20) {
				$msgErr = "word $words[$i] not identified. Try again.";
				return;
			}
		}
		$msg = implode(" ", $words);
	}
}

function validateForm() {
	global $name, $email, $phone, $msg, $emailSubject,
		   $nameErr, $emailErr, $phoneErr, $msgErr;
		   
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (empty($_POST['name'])) {
			$nameErr = "Name is required";
		} else {
			$name = testInput($_POST['name'], "/^[a-zA-Z ]*$/");
			if (is_null($name)) {
				$nameErr = "Only letters and white space allowed";
			}
		}

		if (empty($_POST['email'])) {
			$emailErr = "Email is required";
		} else {
			$email_pattern = "/^[_A-za-z0-9-]+(\.[_A-Za-z0-9-]+)*@[a-z0-9]+(\.[a-z0-9]+)*(\.[a-z]{2,3})$/i";
			$email = testInput($_POST['email'], $email_pattern);
			if (is_null($email)) {
				$emailErr ="Invalid email format";
			}
		}
	
		if (empty($_POST['phone'])) {
			$phoneErr = "Phone is required";
		} else {
			$phone = testInput($_POST['phone'], "/^[0-9]{8}$/");
			if (is_null($phone)) {
				$phoneErr ="Please enter a valid phone number";
			}
		}

		$emailSubject = $_POST['email_subject'];

		if (empty($_POST['msg'])) {
			$msgErr = "Comment is required";
		} else {
			validateComment($_POST['msg']);
		}
	}
}

/*
 * Main code starts here
 */ 
$name = $email = $phone = $msg = $emailSubject = "";
$nameErr = $emailErr = $phoneErr = $msgErr = "";

validateForm();
$emailData = "Name=$name Phone=$phone. $msg";
//echo "<script type='text/javascript'>alert('name=$name, email=$email, phone=$phone, subject=$emailSubject, msg=$emailData');</script>";
//echo "<script type='text/javascript'>alert('Error in name=$nameErr, email=$emailErr, phone=$phoneErr, msg=$msgErr');</script>";

if (!is_null($email) && !is_null($name) && !is_null($phone)) {
	$emailData = wordwrap($emailData, 70, "\r\n");
	$header = 'From: $email' . "\r\n" .
    		  'Reply-To: $email' . "\r\n" .
    		  'X-Mailer: PHP/' . phpversion();
	if (!mail('jaspriyasingh.1@gmail.com', $emailSubject, $emailData, $header)) {
		echo "<script type='text/javascript'>alert('send email failed');</script>";
	}
}

?>