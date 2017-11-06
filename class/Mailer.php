<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mailer
 *
 */
class Mailer {

    private $transport;
    private $from_user;
    public function __construct($smtp, $port, $user, $password, $type = 'tls') {
        $this->from_user = $user;
        require_once realpath('modules/swiftmailer-5.x/lib/swift_required.php');
        $this->transport = Swift_SmtpTransport::newInstance($smtp, $port, $type)
                ->setUsername($user)
                ->setPassword($password);
    }

    public function envoiMail($subject, $to, $body) {
        $message = Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom(array( $this->from_user => "DT Pastries"))
                ->setTo(array($to))
                ->setBody($body, 'text/html');
        return Swift_Mailer::newInstance($this->transport)->send($message);
    }

}
