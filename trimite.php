<?php
//Date mysql
$servername = "localhost";
$dbname = "openjob_open_ga";
$username ="openjob_open_ga";
$password = "szi2jOZc";
?>
    <?php
    $tableContent='<table>';
    foreach ($_POST as $key => $value) {
        $tableContent.= "<tr>";
        $tableContent.=  "<td>";
        $tableContent.=  $key;
        $tableContent.=  "</td>";
        $tableContent.=  "<td>";
        switch ($key){
            case 'email':
                $tableContent.=  '<a href="mailto:'.$value.'">'.$value.'</a>';
                break;
            case 'phone':
                $tableContent.=  '<a href="tel:'.$value.'">'.$value.'</a>';
                break;
            default:
                $tableContent.=  $value;
        }
        $tableContent.=  "</td>";
        $tableContent.=  "</tr>";
    }
    $tableContent.='<table>';
    ?>

<?php
error_reporting(0);
$mainemail = "inscrieri@openjobline.ro , conversii@happy-media.ro";

$name		= $_POST['name'];
$email  	= $_POST['email'];
$subject	= 'Formular LP';
$message	= $tableContent;

$mailinfo  = "MIME-Version: 1.0\r\n";
$mailinfo .= "Content-type: text/html; charset=utf-8\n";
$mailinfo .= "From: inscrieri@openjobline.ro \r\n";
$mailinfo .= "Reply-To: $name <$email>\r\n";

$mail = mail($mainemail, $subject ,$message, $mailinfo);
if($mail){
    echo "<span>Mesajul a fost trimis!</span>";
    //Salveaza in DB;
    //creeaza
    $conn = new mysqli($servername, $username, $password, $dbname);
    // verifica
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //string valori
    $data="'".$_POST['name']."','".$_POST['phone']."','".$_POST['email']."','".$_POST['an']."','".$_POST['mesaj']."','".$_POST['sursa']."'";
    $sql = "INSERT INTO inscrieri (name, phone, email, an, mesaj, sursa) VALUES (".$data.")";

    if ($conn->query($sql) === TRUE) {
        echo "Mulțumim!<br/>";
    } else {
        echo "Vă vom contacta curând.";
        $conn->close();
        die();
    }
    $conn->close();
}
else{
    echo "<span>Eroare! incearca din nou mai tarziu.</span>";
}
$TYsubject="Confirmare inregistrare";
$thankyouContent="<p style=\"margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:.5in;line-height:107%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;\"><strong>Draga ".$name.",</strong></p><br/>
<p style=\"margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:.5in;line-height:107%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;\">Te felicitam pentru decizia de a urma o cariera de AMG in Germania.</p>
<p style=\"margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:.5in;line-height:107%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;\">Multumim pentru interesul tau fata de proiectul nostru si fata de cursul intensiv de limba germana gratuit pentru asistenti absolventi.</p>
<p style=\"margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:.5in;line-height:107%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;\">Vei fi contactat de un membru al echipei noastre cat mai curand! Pana atunci urmareste-ne pe site-ul nostru,&nbsp;
  <a href=\"http://www.openjobline.ro\">www.openjobline.ro</a>, sectiunea Noutati.&nbsp;
</p>
<p style=\"margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:.5in;line-height:107%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;\">&nbsp;</p>
<p style=\"margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:.5in;line-height:107%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;\">Pe curand!</p>
<p style=\"margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:.5in;line-height:107%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;\">Echipa OpenJobLine</p>";
$mail2 = mail($email, $TYsubject ,$thankyouContent, $mailinfo);

    if($mail){
        echo "<span>Mesajul a fost trimis!</span>";
    }
    else{
        echo "<span>Eroare! incearca din nou mai tarziu.</span>";
    }

    header('Location: https://openjobline.ro/lp/thank-you.html');
?>
