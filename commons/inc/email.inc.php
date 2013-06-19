<?php
/*
	application commons
	$Author: Bodart $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/contact_function.inc.php $
	$Revision: 4947 $

	Copyright (C) No Parking 2012 - 2013
*/

class Commons_Email extends Record {

	function send_email($subject, $body, $recipient, $html = false, $bcc = false) {
		require_once dirname(__FILE__)."/../lib/phpmailer/class.phpmailer.php";
		
		$mail = new PHPMailer();
		if (!empty($GLOBALS['config']['email_smtp'])) {
			$mail->IsSMTP();
			$mail->Host = $GLOBALS['config']['email_smtp'];
			$mail->SMTPAuth = false;
		}
		$mail->CharSet = "utf-8";
		$mail->From = $GLOBALS['param']['commons_app_email'];
		$mail->FromName = $GLOBALS['param']['commons_app_name'];
		$mail->AddAddress($recipient);
		if ($bcc === true) {
			$mail->AddBCC($GLOBALS['param']['commons_app_email']);
		}
		$mail->WordWrap = $GLOBALS['param']['email_wrap'];
		$mail->IsHTML($html);
		$mail->Subject = $subject;
		$mail->Body = $body;
		return $mail->send();

	}
	
}