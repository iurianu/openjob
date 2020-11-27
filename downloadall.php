<?php
//se poate accesa cu: https://openjobline.ro/lp/downloadall.php?secret=openjob2020
//downloadeaza un csv toate inscrierile
$secret="";
if (isset($_GET['secret']))
{
    $secret=$_GET['secret'];
}
else
{
    die('error');
}
if ($secret!="openjob2020")
{
    die('error');
}

//Date mysql
$servername = "localhost";
$dbname = "openjob_open_ga";
$username ="openjob_open_ga";
$password = "szi2jOZc";

//creeaza
$conn = new mysqli($servername, $username, $password, $dbname);
// verifica
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//string valori
//$data="'".$_POST['name']."','".$_POST['age']."','".$_POST['oras']."','".$_POST['phone']."','".$_POST['email']."','".$_POST['an']."'";
$sql = 'SELECT name, phone, email, an, mesaj, sursa from inscrieri';
$rows = $conn->query($sql);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=toate_inscrierile.csv');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$output = fopen('php://output', 'w');

fputcsv($output, array('Nume', 'Telefon', 'E-mail', 'An', 'Mesaj', 'Sursa'));

if($rows->num_rows > 0) {
    while ($row = $rows->fetch_assoc())
    {
        fputcsv($output, $row);
    }
}
$conn->close();
