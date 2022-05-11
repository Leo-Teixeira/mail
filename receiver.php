<?php
  require "php/sendMail.php";
  function getIp()
  {
    if(!empty($_SERVER['HTTP_CLIENT_IP']))
    {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }

  //date_default_timezone_set('Europe/Paris');

  $id = htmlspecialchars($_GET['id'] ?? die());

  /* Load json */
  $data = json_decode(file_get_contents("json/final.json"), true);

  /* Load stolen */
  $stl = json_decode(file_get_contents("json/stolen.json"), true);
  $stl[array_search($id, $data)] = array($id, date("l j/m/Y H:i:s"), getIp());

  /* Save stolen */
  file_put_contents("json/stolen.json", json_encode($stl));

  /* Send Mail */
  $mail = connexion_smtp("smtp.auth.orange-business.com", "info@groupe-step.com", "Inf34Ste@", "info@groupe-step.com", "Groupe-Step");
  send_mail($mail, array_search($id, $data), '<h1 style="text-align:center;"> Sensibilisation aux mails frauduleux </h1><br>
  Ne cliquez pas sur un mail qui vous paraîtrais dangereux, celui-ci en est un exemple.<br><br>
  Certains mails qui ont pourtant une allure de mail normal, sont en fait des mails qui servent a prendre vos données.
  <br><br>Afin d’évité ce problème nous vous conseillons:<br><br> - de toujours regarder de qui provient le mail.
  <br><br>- Vérifiez également que le mail n’est pas de faute d’orthographe par exemple.<br><br>- Et la chose primordiale à faire attention est de ne jamais cliquer sur une pièce jointe tant que vous n’êtes pas sûr de la validité du mail.<br><br>
  En conclusion n’ouvrez jamais un mail qui vous paraîtrais suspect et informez-en immédiatement le service informatique.<br><br>
  Pour plus d\'information consulter ce site : <a href="https://www.cybermalveillance.gouv.fr/tous-nos-contenus/fiches-reflexes/hameconnage-phishing">Site du gouvernement.</a>', "Sensibilisation aux mails frauduleux");
?>

<html>
<head>
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
<video autoplay loop id="background">
  <source src="res/background.mp4" type="video/mp4">
</video>
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
<script src="js/script.js"></script>