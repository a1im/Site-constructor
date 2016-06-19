<?php

$to = "venshop@yandex.ru";

$subject = "Подписка на монеты";
$message = "Подписка на монеты.\r\n";

$phone = null;
$name = null;
$email = null;
if(isset($_POST['phone'])){ $phone=$_POST['phone']; }
if(isset($_POST['name'])){ $name=$_POST['name']; }
if(isset($_POST['email'])){ $email=$_POST['email']; }
function clearString($string){
	return htmlspecialchars(stripslashes($string));
}
$name = clearString($name);
$phone = clearString($phone);
$email = clearString($email);

if($name){
	$message .= "Имя клиента: " . $name . ".\r\n";
}
if($phone){
	$message .= "Телефон клиента: " . $phone . ".\r\n";
}
if($email){
	$message .= "E-mail клиента: " . $email . ".\r\n";
}

$headers = "";
$headers .= "MIME-Version: 1.0 \r\n"; 
$headers .= "Content-type: text/plain; charset=utf-8 \r\n";
$headers .= "Subject: " . $subject . " \r\n"; 
$headers .= "X-Mailer: PHP/".phpversion()."\r\n";

mail($to, $subject, $message, $headers);

echo 'Заявка отправлена!';
//echo "<meta http-equiv='Refresh' content='0; URL=thanks/'>";



