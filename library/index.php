<?php
    	 
require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->isSMTP();                            // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                     // Enable SMTP authentication
$mail->Username = 'sadiqi@assistconsultants.com'; // your email id
$mail->Password = 'ssdsdsdsddds'; // your password
$mail->SMTPSecure = 'tls';                  
$mail->Port = 587;     //587 is used for Outgoing Mail (SMTP) Server.
$mail->setFrom('a.sami.sadiqi2017@gmail.com', 'Abdul Sami');
$mail->addAddress('sohaibraoufi@gmail.com');   // Add a recipient
$mail->isHTML(true);  // Set email format to HTML

$bodyContent = '<h1>HeY!,</h1>';
$bodyContent .= '<p>This is an opurtunity to bid many projects.</p>';
$mail->Subject = 'Email from Localhost by Abdul Sami';
$mail->Body    = $bodyContent;
$mail->AddAttachment("attachment/fbcover.png");
if(!$mail->send()) {
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  echo 'Message has been sent.';
}

?>
