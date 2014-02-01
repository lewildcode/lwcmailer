<?php

namespace LwcMailer\Service;

use Zend\Mail\Message;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;

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
     * @param string $textContent
     * @param string $html
     * @throws \RuntimeException
     * @return \Zend\Mail\Message
     */
    public function createMail ($subject, $textContent, $html = null)
    {
        $options = $this->getOptions();

        if($options->getDefaultFrom() === null) {
            throw new \RuntimeException('No default sender given!');
        }
        $mail = new Message();
        $mail->setEncoding($options->getEncoding())
             ->setSubject($subject)
             ->setFrom($options->getDefaultFrom(), $options->getDefaultFromName());

        // add recipients
        foreach($options->getRecipients() as $email => $name) {
            $mail->addTo($email, $name);
        }

        // add mime parts
        $body = new MimeMessage();

        // plaintext
        $text = new MimePart($textContent);
        $text->type = "text/plain";
        $body->addPart($text);

        // do we have html?
        if($html !== null) {
            $html = new MimePart($html);
            $html->type = "text/html";
            $body->addPart($html);
        }

        return $mail->setBody($body);
    }

    /**
     * @param Message $message
     */
    public function send (Message $message)
    {
        return $this->getOptions()->getTransport()->send($message);
    }
}