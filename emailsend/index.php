<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';

  $mail = new PHPMailer();
  $mail->IsSMTP();
	
	
  $mail->SMTPDebug  = 0; 
$mail->SMTPAuth = false;
$mail->SMTPAutoTLS = false;   
  $mail->SMTPAuth   = TRUE;
  $mail->SMTPSecure = "tls";
  $mail->Port       = 587;
  $mail->Host       = "smtp.gmail.com";
  $mail->Username   = "4mailbot@gmail.com";
  $mail->Password   = "grumpybomb";

  $mail->Host       = "mail.nusantarajaya.co.id";
  $mail->Username   = "noreply_trial@nusantarajaya.co.id";
  $mail->Password   = "qazplm-123";
  $mail->CharSet	= "iso-8859-1";
  //noreply_trial@nusantarajaya.co.id	
//pass : qazplm-123
  

  $mail->IsHTML(true);
  $mail->AddAddress("itsbombking@gmail.com", "cek");
  $mail->SetFrom("4mailbot@gmail.com", "sender");
  $mail->AddReplyTo("4mailbot@gmail.com", "reply-to-name");
  //$mail->AddCC("cc-recipient-email", "cc-recipient-name");
  $mail->Subject = "PHP Mailer Tes";
  $content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>".$mail->Host;

  $mail->MsgHTML($content); 
  if(!$mail->Send()) {
    echo "Error while sending Email.";
    var_dump($mail);
  } else {
    echo "Email sent successfully";
  }
?>