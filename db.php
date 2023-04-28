<?php
include("connection.php");

if(isset($_POST["email"]) && (!empty($_POST["email"]))){
$email = $_POST["email"];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$email) {
   $error .="<p>Érvénytelen e-mail cím, kérjük, írjon be egy érvényes e-mail címet!</p>";
   }else{
   $sel_query = "SELECT * FROM `user` WHERE email='".$email."'";
   $results = mysqli_query($con,$sel_query);
   $row = mysqli_num_rows($results);
   if ($row==""){
   $error .= "<p>Nincs regisztrálva felhasználó ezzel az e-mail címmel!</p>";
   }
  }
   if($error!=""){
   echo "<div class='error'>".$error."</div>
   <br /><a href='javascript:history.go(-1)'>Vissza az előzö oldalra</a>";
   }else{
   $token = md5(2418*2+$email);
   $addKey = substr(md5(uniqid(rand(),1)),3,10);
   $token = $token . $addKey;
// Insert Temp Table
mysqli_query($con,
"INSERT INTO `user` (`email`, `token`)
VALUES ('".$email."', '".$token."');");

$output='<p>Kedves felhasználó,</p>';
$output.='<p>Kérjük, kattintson az alábbi linkre jelszava visszaállításához.</p>';
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p><a href="https://www.vegetarsgr.hu/reset-password.php?
token='.$token.'&email='.$email.'&action=reset" target="_blank">
https://www.vegetarsgr.hu/reset-password.php
?token='.$token.'&email='.$email.'&action=reset</a></p>';		
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p>Kérjük, feltétlenül másolja be a teljes linket a böngészőjébe.
A link biztonsági okokból 1 nap múlva lejár.</p>';
$output.='<p>Ha nem Ön kérte ezt az elfelejtett jelszóval kapcsolatos e-mailt, nincs teendő
szükséges, akkor a jelszava nem lesz visszaállítva. Érdemes azonban bejelentkezni
fiókját, és módosítsa biztonsági jelszavát, ahogy azt valaki kitalálta.</p>';   	
$output.='<p>Köszönettel,</p>';
$output.='<p>Vegetarsgr csapata</p>';
$body = $output; 
$subject = "Jelszó visszaállítás - vegetarsgr.hu";

$email_to = $email;
$fromserver = "noreply@yourwebsite.com"; 
require("PHPMailer/PHPMailerAutoload.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = "mail.yourwebsite.com"; // Enter your host here
$mail->SMTPAuth = true;
$mail->Username = "noreply@yourwebsite.com"; // Enter your email here
$mail->Password = "vegetarsgr"; //Enter your password here
$mail->Port = 25;
$mail->IsHTML(true);
$mail->From = "noreply@yourwebsite.com";
$mail->FromName = "AllPHPTricks";
$mail->Sender = $fromserver; // indicates ReturnPath header
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($email_to);
if(!$mail->Send()){
echo "Mailer Error: " . $mail->ErrorInfo;
}else{
echo "<div class='error'>
<p>Elküldtünk Önnek egy e-mailt a jelszó visszaállításához szükséges utasításokkal.</p>
</div><br /><br /><br />";
	}
   }
}else{
?>
<form method="post" action="" name="reset"><br /><br />
<label><strong>Enter Your Email Address:</strong></label><br /><br />
<input type="email" name="email" placeholder="username@email.com" />
<br /><br />
<input type="submit" value="Jelszó visszaállítása"/>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php } ?>