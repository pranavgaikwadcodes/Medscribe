<?php
include('smtp/PHPMailerAutoload.php');

include('./DB/config.php');

$token = $_GET['Token'];
$ID = $_GET['ID'];

$html='link to reset your password : http://localhost/Hospital-Management-System-master/forgot-password.php?password-reset=True&Token='.$token.'&ID='.$ID.'';

echo smtp_mailer($ID,'Reset Password',$html);
function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->SMTPDebug  = 3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "pacific11gaming@gmail.com";
	$mail->Password = "tzrgqsolywxxvxwl";
	$mail->SetFrom("pacific11gaming@gmail.com");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		header('location: ../forgot-password.php');
	}
}
?>