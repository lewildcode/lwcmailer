<?php

namespace LwcMailer\Service;

use Zend\Mail\Message;

class MailerService
{
    /**
     * @var MailerServiceOptions
     */
    protected $options;

    /**
     * @param MailerServiceOptions $options
     */
    public function __construct(MailerServiceOptions $options)
    {
        $this->setOptions($options);
    }

    /**
     * @return \LwcMailer\Service\MailerServiceOptions
     */
    public function getOptions ()
    {
        return $this->options;
    }

    /**
     * @param MailerServiceOptions $options
     * @return \LwcMailer\Service\MailerService
     */
    public function setOptions (MailerServiceOptions $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param string $subject
     * @return \Zend\Mail\Message
     */
    public function createMail ($subject, $body)
    {
        $options = $this->getOptions();

        if($options->getDefaultFrom() === null) {
            throw new \RuntimeException('No default sender given!');
        }
        $mail = new Message();
        $mail->setEncoding($options->getEncoding())
             ->setSubject($subject)
             ->setBody($body)
             ->setFrom($options->getDefaultFrom(), $options->getDefaultFromName());

        foreach($options->getRecipients() as $email => $name) {
            $mail->addTo($email, $name);
        }
        return $mail;
    }

    /**
     * @param Message $message
     */
    public function send (Message $message)
    {
        return $this->getOptions()->getTransport()->send($message);
    }
}