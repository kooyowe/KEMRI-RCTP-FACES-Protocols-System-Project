<?php
/*	+---------------------------------------------------------------------------------------+
	|Script: Sendmail
	|Language: PHP
	|Author: Kevin Oyowe
	|->This script sends an email to the specified email address that belongs to
	|	the PI(Principal Investigator) whose Protocol is set to expired at the time of
	|	running the script.
	|->Uses Google's SMTP server with the following email address:
	|	username:	kemrifaces@gmail.com
	|	Account Name:	Protocols System
	+----------------------------------------------------------------------------------------+
*/
//php time zone
date_default_timezone_set('Africa/Nairobi');

//mail variables
$emailTo = '';
$replyTo = '';
$ccTo = '';
$currentDate = new DateTime();
//..
$expiryDate = new DateTime();
$transid = 0;
$sign = '';
$days = 0;

//SCRIPT main
//-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.
require_once "../classes/DbObject.php";
require_once '../PHPMailer/PHPMailerAutoload.php';
$db = new DbObject();
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

//protocols
$protocolQ="SELECT * FROM protocol";
$protocolStmt = $db->prepare($protocolQ);
$protocolStmt->execute();
while($protocolRow = $protocolStmt->FetchObject()){
	$proid = $protocolRow->protocol_id;
	$protocolTitle = $protocolRow->protocol_title;
	$protocolDesc = $protocolRow->protocol_desc;
	$accid = $protocolRow->account_id;
	$discontinue = $protocolRow->discontinue;
	
	//account
	$accountQ="SELECT * FROM account WHERE account_id=".$accid;
	$accountStmt = $db->prepare($accountQ);
	$accountStmt->execute();
	$accountRow = $accountStmt->FetchObject();
	$surname = $accountRow->surname;
	$emailTo = $accountRow->email_address;
	$title = $accountRow->title;
	
	//transaction
	$transactionQ="SELECT * FROM protocol_transactions where protocol_id=".$proid.' ORDER BY transaction_id DESC';
	$transactionStmt = $db->prepare($transactionQ);
	$transactionStmt->execute();
	$transactionRow = $transactionStmt->FetchObject();	
	if(isset($transactionRow->transaction_id)){
		$expiryDate = date_create($transactionRow->expiry_date);
		$transid = $transactionRow->transaction_id;
		
		$diff=date_diff($currentDate,$expiryDate);
		$sign = $diff->format("%R");
		$days = $diff->format("%a");
		
		echo $sign.' '.$days.' days<br>';
		echo $protocolTitle.'<br>';
		
		if(($sign=='+')&&(($days==60)||($days==44)||($days==30))){
			echo '<u>To be Emailed today</u><br>';
			echo 'Protocol : '.$protocolTitle.'<br>';
			echo 'Description : '.$protocolDesc.'<br>';
			echo 'Email To: '.$emailTo.'<br>';
			echo 'Recipient: '.$title.' '.$surname.'<br>';
			echo '<br><u>The following is the Constructed Message:</u><br>';
			$htmlMessage = '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
				<html>
				<body>
				  <div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
					<table width="100%" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
						<tr>
							<td rowspan="4">
								<h2>Protocols Management System</h2>
							</td>
						</tr>
						<tr>
							<td align="right">
								<b>KEMRI-RCTP</b>
							</td>
						</tr>
						<tr>
							<td align="right">
								<b>Nairobi</b>
							</td>
						</tr>
						<tr>
							<td align="right">
								<b>
									<u>'.date_format($currentDate,"jS F Y").'</u>
								</b>
							</td>
						</tr>		
					</table>
					<table width="100%" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; border-bottom:1px solid green">
						<tr >
							<td>
							<p>
							Dear '.$title.' '.$surname.',
							</p>
							
							<p>
							<b><u>RE: KEMRI-RCTP PROTOCOL STUDY REMINDER</u></b>
							</p>
							
							<p>
							Your Protocol: [<b>'.$protocolTitle.'</b>]
							<br>
							<b>'.$protocolDesc.'.</b>
							</p>
							<p>
							Please note that your protocol expires on [<b>'.date_format($expiryDate, "jS F Y").'</b>]. Kindly file for Annual renewal and Submit to SERU (Scientific and Ethics Review Unit).
							</p>
							
							<p>
							Regards,<br>
							Team
							</p>
							<br>
							<br>
							</td>
						</tr>
					</table>
					<span style="color:blue">
					You are getting this message as free service for being a user of the KEMRI-RCTP FACES Protocols Management System(ProMS) Pilot Test Vs 1.0.
					This email has been copied to the officers in charge of the system development as a Post Implementation Strategy.
					</span>
				  </div>
				</body>
				</html>
			';
			
			$alternativeMessage = '

				Protocols Management System
				
				Dear '.$title.' '.$surname.'
				
				RE: KEMRI-RCTP PROTOCOL STUDY REMINDER
				
				Your Protocol: ['.$protocolTitle.']<br>
				'.$protocolDesc.'.
				
				Please note that your protocol expires on [<b>'.date_format($expiryDate, "jS F Y").'</b>]. Kindly file for Annual renewal and Submit to SERU (Scientific and Ethics Review Unit).
				
				Regards,
				Team
			';
			
			SendMail($emailTo,$replyTo,$htmlMessage,$alternativeMessage);
			
		}elseif($sign=='-'){
			echo 'Mailing day past<br>';
		}else{
			echo 'Not yet mailing day';
		}
		echo '<hr>';
	}
}
//-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.
//END


//sends the email
function SendMail($emailTo,$replyTo,$htmlMessage,$alternativeMessage){
	//require '../PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 2;
	$mail->Debugoutput = 'html';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->Username = "kemrifaces@gmail.com";
	$mail->Password = "kemri-faces123";
	$mail->setFrom('kemrifaces@gmail.com', 'Protocols System');
	$mail->addReplyTo($replyTo);
	$mail->addAddress($emailTo);
	//$mail->addCC('koyowe@kemri-ucsf.org');
	$mail->addCC('timokips@gmail.com');
	$mail->addCC('pnjenga@rctp.or.ke');
	$mail->addCC('rmwakisha@rctp.or.ke');
	$mail->addCC('koyowe@kemri-ucsf.org');
	$mail->addCC('emulwa@kemri-ucsf.org');
	$mail->addCC('ckibaara@kemri-ucsf.org');
	//$mail->addCC('ebukusi@kemri-ucsf.org');
	$mail->Subject = 'Protocol Study Reminder';
	$mail->msgHTML($htmlMessage);
	$mail->AltBody = $alternativeMessage;
	if (!$mail->send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	echo "Message sent!";
	}
}

//test the message