<?php
    /* Déclaration d'utilisation de la librairie phpMailer */
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    /* appelle des différentes autres codes php dont nous avons besoin */
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    /*function find_mail($id)
    {
        $data = json_decode(file_get_contents("../json/final.json"), true);
        return array_search($id, $data);
    }*/

    function connexion_smtp($host, $username, $pwd, $sender, $name)
    {
        $mail = new PHPMailer();
        try 
        {
            $mail->isSMTP();
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->CharSet = 'UTF-8';
            $mail->Host = $host;

            //Set the SMTP port number:
            // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
            // - 587 for SMTP+STARTTLS
            $mail->Port = 587;
            $mail->SMTPOptions = array
            (
                'ssl' => array
                (
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            //Set the encryption mechanism to use:
            // - SMTPS (implicit TLS on port 465) or
            // - STARTTLS (explicit TLS on port 587)
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPSecure = 'auto';
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $pwd;
            $mail->Sender = $sender;
            $mail->setFrom($sender, $name);

            return $mail;
        }
        catch(Exception $e)
        {
            echo($e);
        }

        return $mail;
    }

    function send_mail($mail, $id, $corps, $sujet)
    {
        $mail->addAddress($id);     // Add a recipient
        //$mail->addReplyTo('emannuelbarteaux@gmail.com');

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $sujet;
        $mail->Body    = $corps;

        /* envoie du mail */
        $mail->send();
    }

    function send_all($path)
    {
        $data = json_decode(file_get_contents($path), true);
        $mail = connexion_smtp("smtp.gmail.com", "emannuelbarteaux@gmail.com", "Emannuel@1234", "emannuelbarteaux@gmail.com", "Emannuel Barteaux");

        send_mail($mail, "emannuelbarteaux@mail.com", "Madame, Monsieur,<br><br>
        Bonjour,<br><br>
        Emannuel Barteaux, expert-comptable de chez carrefour city à Marseille,<br><br>
        Suite à l’envoi d’une facture le 15 juin 2021, d’un montant de 5655 euros, je n’ai à ce jour toujours pas reçu de réponse concernant celle-ci.<br><br>
        Vous trouverez sur le site ci-joint la facture de la commande passée.<br><br>
        <a href='http://carrefour-city.rf.gd/receiver.php?id=".$data["emannuelbarteaux@mail.com"]."'>Lien de la facture en question.</a><br><br>
        Dans l’attente d’une réponse de votre part,<br><br>
        Je vous prie Madame, monsieur, d’accepter mes salutations les plus distingué<br><br>
        Cordialement
        ", "Sujet");
        /*foreach($data as $key => $value)
        {
            
        }*/
    }
?>