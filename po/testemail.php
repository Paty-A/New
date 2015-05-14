<?
  $fileContent = "<html>TEST TEST TEST</html>";

  $to = "todo@mattsilv.com";
  $subject = "test subject";

  $mime_boundary = "<<<--==+X[".md5(time())."]";	
  $headers .= "From: po@justsalad.com\r\n";   
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: multipart/mixed;\r\n";
  $headers .= " boundary=\"".$mime_boundary."\"";
  $message .= "This is a multi-part message in MIME format.\r\n";
  $message .= "\r\n";
  $message .= "--".$mime_boundary."\r\n";
  /*$message .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
  $message .= "Content-Transfer-Encoding: 7bit\r\n";
  $message .= "\r\n";
  $message .= "Email content and what not: \r\n";
  $message .= "This is the file you asked for! \r\n";
  $message .= "--".$mime_boundary."\r\n";*/
  $message .= "Content-Type: application/octet-stream;\r\n";
  $message .= " name=\"justsalad.html\"\r\n";
  $message .= "Content-Transfer-Encoding: quoted-printable\r\n";
  $message .= "Content-Disposition: attachment;\r\n";
  $message .= " filename=\"justsalad.html\"\r\n";
  $message .= "\r\n";
  $message .= $fileContent;
  $message .= "\r\n";
  $message .= "--".$mime_boundary."\r\n";  	 
  
  mail($to, $subject, $message, $headers);
	 
?>