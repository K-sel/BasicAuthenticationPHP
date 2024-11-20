<?php
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

try {

    $transport = Transport::fromDsn('smtp://localhost:1025');
    $mailer = new Mailer($transport);
    $email = (new Email())
        ->from('no-reply@heig-vd.ch')
        ->to($utilisateur->getEmail())
        ->subject('Concerne : Vérification de votre adresse E-mail')
        //->text()
        ->html('<p>Votre token de vérification : </p>' .
            '<a href="http://localhost/ProgServ/Authentification/verify.php?token=' . urlencode($token) . '">Vérifier mon mail</a>');
    $result = $mailer->send($email);
    if ($result == null) {
        echo "<BR>Un mail a été envoyé ! <a href='http://localhost:8025'>voir le mail</a>";
    } else {
        echo "Un problème lors de l'envoi du mail est survenu";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}