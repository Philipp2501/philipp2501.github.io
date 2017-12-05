<?php

$header .= "Mime-Version: 1.0\r\n";
$header .= "Content-type: text/plain; charset=utf-8";

if(isset($_POST['email'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "web@philippgeissler.de";
    $email_subject = "[PG]: Kontaktformular";

    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }

    // validation expected data exists
    if(!isset($_POST['surname']) ||
        !isset($_POST['forename']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    $surname = $_POST['surname']; // required
    $forename = $_POST['forename']; // required
    $phone = $_POST['phone']; // not required
    $email = $_POST['email']; // required
    $message = $_POST['message']; // required
    $response = $_POST["g-recaptcha-response"];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
      'secret' => '6LeqszsUAAAAANcsUasak0qeMMVm3ubSRkes4d-b',
      'response' => $_POST["g-recaptcha-response"]
    );

    $options = array(
      'http' => array (
        'method' => 'POST',
        'content' => http_build_query($data)
      )
    );
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success=json_decode($verify);

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

/*
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }

    $string_exp = "/^[A-Za-z .'-]+$/";

  if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
  }

  if(!preg_match($string_exp,$last_name)) {
    $error_message .= 'The Last Name you entered does not appear to be valid.<br />';
  }

  if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
*/

  if(strlen($error_message) > 0) {
    died($error_message);
  }

    $email_message = "Form details below.\n\n";


    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

    $email_message .= "Vorname: ".clean_string($forename)."\n";
    $email_message .= "Nachname: ".clean_string($surname)."\n";
    $email_message .= "Email: ".clean_string($email)."\n";
    $email_message .= "Telefon: ".clean_string($phone)."\n";
    $email_message .= "Nachricht: ".clean_string($message)."\n";

// create email headers
$headers = 'From: '.$email."\r\n".
'Reply-To: '.$email."\r\n" .
'X-Mailer: PHP/' . phpversion();

if ($captcha_success->success==false) {

  ?>

  <!-- include your own fail html here -->

<!DOCTYPE HTML>
<!--
	Stellar by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>Philipp Geißler</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!--[if lte IE 8]>
    <script src="assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/main.css"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="assets/css/ie9.css"/><![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="assets/css/ie8.css"/><![endif]-->
</head>
<body>

<!-- contactFail -->
<div id="failContact">

    <!-- Header -->
    <header id="header">
        <h2>Versand der Nachricht ist fehlgeschlagen!</h2>
    </header>

    <!-- Main -->
    <div id="main">

        <!-- Content -->
        <section id="content" class="main" style="text-align: center">
            <p>Bitte gehen Sie zurück, aktivieren Sie das reCaptcha, um als Person verifiziert zu werden und schicken das Formular erneut.</p>
            <ul class="actions">
                <li><a href="javascript:history.back()" class="button special">Zurück zur Webseite</a></li>
            </ul>
        </section>

    </div>

    <!-- Footer -->
    <footer id="footer">
        <section>
            <h2>Starten Sie noch heute!</h2>
            <p>Nutzen Sie die Chancen der Digitalisieren und präsentieren Sie Ihr Unternehmen auf eine neue Weise. Wir
                freuen uns auf Ihre Kontaktaufnahme sowie eine Zusammenarbeit.</p>
            <ul class="actions">
                <li><a href="#contact" class="button">Kontakt</a></li>
            </ul>
        </section>
        <section>
            <h2>Kontaktdaten</h2>
            <dl class="alt">
                <dt>Telefon</dt>
                <dd>+49 (0) 173 2070306</dd>
                <dt>Email</dt>
                <dd><a href="#">info [AT] philippgeissler.de</a></dd>
            </dl>
            <ul class="icons">
                <li><a href="https://www.xing.com/profile/Philipp_Geissler4" class="icon fa-xing alt"><span
                        class="label">Xing</span></a></li>
                <li><a href="https://www.linkedin.com/in/philippgeissler/" class="icon fa-linkedin alt"><span
                        class="label">Facebook</span></a></li>
            </ul>
        </section>
        <p class="copyright">&copy; philippgeissler. Design: <a href="https://html5up.net">HTML5 UP</a>. <a
                href="impressum.html">Impressum</a>. <a href="datenschutz.html">Datenschutz</a>.</p>
    </footer>

</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<!--[if lte IE 8]>
<script src="assets/js/ie/respond.min.js"></script><![endif]-->
<script src="assets/js/main.js"></script>

</body>
</html>


  <?php

} else if ($captcha_success->success==true) {
  @mail($email_to, $email_subject, $email_message, $headers);

  ?>

  <!-- include your own success html here -->

<!DOCTYPE HTML>
<!--
	Stellar by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>Philipp Geißler</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!--[if lte IE 8]>
    <script src="assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/main.css"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="assets/css/ie9.css"/><![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="assets/css/ie8.css"/><![endif]-->
</head>
<body>

<!-- contactSuccess -->
<div id="successContact">

    <!-- Header -->
    <header id="header">
        <h2>Vielen Dank für Ihre Nachricht!</h2>
    </header>

    <!-- Main -->
    <div id="main">

        <!-- Content -->
        <section id="content" class="main" style="text-align: center">
            <p>Wir werden uns umgehend bei Ihnen melden.</p>
            <ul class="actions">
                <li><a href="javascript:history.back()" class="button special">Zurück zur Webseite</a></li>
            </ul>
        </section>

    </div>

    <!-- Footer -->
    <footer id="footer">
        <section>
            <h2>Starten Sie noch heute!</h2>
            <p>Nutzen Sie die Chancen der Digitalisieren und präsentieren Sie Ihr Unternehmen auf eine neue Weise. Wir
                freuen uns auf Ihre Kontaktaufnahme sowie eine Zusammenarbeit.</p>
            <ul class="actions">
                <li><a href="#contact" class="button">Kontakt</a></li>
            </ul>
        </section>
        <section>
            <h2>Kontaktdaten</h2>
            <dl class="alt">
                <dt>Telefon</dt>
                <dd>+49 (0) 173 2070306</dd>
                <dt>Email</dt>
                <dd><a href="#">info [AT] philippgeissler.de</a></dd>
            </dl>
            <ul class="icons">
                <li><a href="https://www.xing.com/profile/Philipp_Geissler4" class="icon fa-xing alt"><span
                        class="label">Xing</span></a></li>
                <li><a href="https://www.linkedin.com/in/philippgeissler/" class="icon fa-linkedin alt"><span
                        class="label">Facebook</span></a></li>
            </ul>
        </section>
        <p class="copyright">&copy; philippgeissler. Design: <a href="https://html5up.net">HTML5 UP</a>. <a
                href="impressum.html">Impressum</a>. <a href="datenschutz.html">Datenschutz</a>.</p>
    </footer>

</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<!--[if lte IE 8]>
<script src="assets/js/ie/respond.min.js"></script><![endif]-->
<script src="assets/js/main.js"></script>

</body>
</html>

  <?php

}



}
?>
