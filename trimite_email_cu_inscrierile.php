<?php
//https://openjobline.ro/lp/trimite_email_cu_inscrierile.php
//verifica secret

if (!isset($argv[1])) {die('error');}
if ($argv[1]!="openjob2020") {die('error(s)');}

//ini phpmailer
require_once('mailer/PHPMailer.php');
require_once('mailer/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;

//date sql
$servername = "localhost";
$dbname = "openjob_open_ga";
$username ="openjob_open_ga";
$password = "szi2jOZc";

//date mail
$expeditor="inscrieri@openjobline.ro";
//$destinatar1="office@openjobline.ro";
//$destinatar2="conversii@happy-media.ro";
$destinatar3="ciprian.pentelescu@gmail.com";
$body="Situatie zilnica inscrieri\n\r";

//creeaza conn
$conn = new mysqli($servername, $username, $password, $dbname);

// verifica conn
if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}
else
{
//executa sql
$sql ='SELECT name, phone, email, an, sursa, date from inscrieri where date>=DATE_SUB(NOW(),INTERVAL 7 DAY)';
//die($sql);
$rows = $conn->query($sql);
$file=substr(str_shuffle('0123456789'),1,5);
$output = fopen('/tmp/output'.$file, 'w');

fputcsv($output, array('Nume', 'Telefon', 'E-mail', 'An', 'Sursa'));

if($rows->num_rows > 0) {
    while ($row = $rows->fetch_assoc())
    {fputcsv($output, $row);}
}
    fclose($output);
$conn->close();

$mail = new PHPMailer(true);
$mail->SetFrom($expeditor);
$mail->AddReplyTo($expeditor);
//$mail->AddAddress($destinatar1);
//$mail->AddAddress($destinatar2);
$mail->AddAddress($destinatar3);
$mail->addAttachment( '/tmp/output'.$file,'Raport_'.date("d.m.yy").'.csv');
$mail->Subject    = "Raport Saptamanal - ".date("d.m.yy");
$mail->Body       = $body;

$result = $mail->Send();
if (!$result)
{echo 'error'. $mail->ErrorInfo;}
else
{echo 'trimis';}

}
