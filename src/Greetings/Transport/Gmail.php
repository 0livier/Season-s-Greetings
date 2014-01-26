<?php

namespace Greetings\Transport;

use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

class Gmail {

    protected $mailer = null;

    public function __construct($username, $password)
    {
        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')
            ->setUsername($username)
            ->setPassword($password);
        $this->mailer = Swift_Mailer::newInstance($transport);
    }

    public function send($from, $recipient, $subject, $htmlBody)
    {
        $message = Swift_Message::newInstance($subject);
        $message->setBody($htmlBody, 'text/html');
        $message->setFrom($from);
        $message->setTo($recipient);

        $this->mailer->send($message);
    }

} 