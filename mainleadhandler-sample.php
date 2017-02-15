<?php 
$lead_sent = "no";
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$beds = $_POST['size-min']." - ".$_POST['size-max'];
$costamount = $_POST['cost-min']." - ".$_POST['cost-max'];

$optl = $_POST['optl'];
$area = $_POST['area'];

if(isset($_POST['thesizeamount'])){
$sizeamount = $_POST['thesizeamount'];
}
if(isset($_POST['costamount'])){
$costamount = $_POST['costamount'];
}

if (isset($_POST['parking'])){
	$parking = $_POST['parking'];
}
if (isset($_POST['saletype'])){
	$type = $_POST['saletype'];
}
$pets = "";
if (isset($_POST['pets-cat'])){
	$pets .= $_POST['pets-cat']." ";
}
if (isset($_POST['pets-dog'])){
	$pets .= $_POST['pets-dog']." ";
}

$errors = array();


foreach($_POST as $key=>$value) {
	$href = stripos($value, 'href');
	$src = stripos($value, 'src');
	if ($href != NULL) {
		$errors[] = "Sorry, We cannot currently accept links in this form.";
	}
	if ($src != NULL) {
		$errors[] = "Sorry, We cannot currently accept links in this form.";
	}
}

if (in_array('src=', $_POST) == true ) {
	$errors[] = "Sorry, We cannot currently accept links in this form.";
}
if (in_array('href=', $_POST) == true ) {
	$errors[] = "Sorry, We cannot currently accept links in this form.";
}

preg_match_all("/[^0-9()-.\s]/", $phone, $phoneCheck);

if (is_array($phoneCheck) && count($phoneCheck[0]) > 0) {
	$errors[] = "Sorry, phone number may only contain numbers or:  ( ) . -";
}

if( count($errors) > 0 ) {
	echo "<ul id='errors'>";
	foreach ($errors as $error) {
		echo "<li>".$error."</li>";
	}
	echo "</ul>";
	$lead_sent = "no";
	
}
else {
	echo "Thank you!  A luxe agent will contact you within 24 hours.";

	$template = "<table border='0' style='width: 100%; height: 100%; margin: 0; padding: 20px;  font-size: 14px; font-family: Century Gothic, Ariel, sans-serif;'>
	<tr>
    	<td>
        	<h1 style='-webkit-border-top-left-radius: 20px;-webkit-border-top-right-radius: 20px;-moz-border-radius-topleft: 20px;-moz-border-radius-topright: 20px;border-top-left-radius: 20px;border-top-right-radius: 20px;background: #4a7c99; padding: 10px 20px; width: 300px; font-size: 1.2em; color: white; margin: 0;'>New Lead Registered!</h1>
            <div style='-webkit-border-bottom-right-radius: 20px;-webkit-border-bottom-left-radius: 20px;-moz-border-radius-bottomright: 20px;-moz-border-radius-bottomleft: 20px;border-bottom-right-radius: 20px;border-bottom-left-radius: 20px;width: 300px; background: #EFEFEF; padding: 5px 20px 10px 20px; line-height: 1.75em'>
        	Name: ".$firstname." ".$lastname."<br>
            Phone: ".$phone."<br>
            Email: ".$email."<br>";
				if($optl == "yes") {$template .= "
					Looking to: ".$type."<br>
					Area: ".$area."<br>
					Beds: ".$beds."<br>
					Price range: ".$costamount."<br>
					";
					if (isset($parking)){
						$template .= "Parking: ".$parking."<br>";
					}
					if (isset($pets)){
						$template .= "Pets: ".$pets."<br>";
					}
				}
				$template .="
				Sent from: MainHandler</div>
			</td>
		</tr>
	</table>
	";
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Alfred Pennyworth <donotreply@domain.com>' . "\r\n";
	$to = "recipient@domain.com";
	$subject = "New Lead Available";
	
	mail($to, $subject, $template, $headers);
		
	
}


?>