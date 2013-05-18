<?php

namespace LwcMailer\Service;

use Zend\Stdlib\AbstractOptions;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mail\Transport\Sendmail;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\File;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail\Transport\FileOptions;

class MailerServiceOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $transportOptions;

    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * @var string
     */
    protected $defaultFrom;

    /**
     * @var string
     */
    protected $defaultFromName;

    /**
     * @var string
     */
    protected $encoding = 'utf-8';

    /**
     * @var array
     */
    protected $recipients = array();

    /**
     * @param array|Traversable|null $options
     * @throws \InvalidArgumentException
     */
    public function __construct($options = null)
    {
        if(is_array($options) && isset($options['transportOptions'])) {
            $this->setTransportOptions($options['transportOptions']);
            unset($options['transportOptions']);
        }
        parent::__construct($options);
    }

    /**
     * @param string $encoding
     * @return \LwcMailer\Service\MailerServiceOptions
     */
    public function setEncoding ($encoding)
    {
        $this->encoding = trim($encoding);
        return $this;
    }

    /**
     * @return string
     */
    public function getEncoding ()
    {
        return $this->encoding;
    }

    /**
     * @param array $recipients
     * @return \LwcMailer\Service\MailerServiceOptions
     */
    public function setRecipients (array $recipients)
    {
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * @return array
     */
    public function getRecipients ()
    {
        return $this->recipients;
    }

    /**
     * @return string
     */
    public function getDefaultFromName ()
    {
        return $this->defaultFromName;
    }

    /**
     * @param string $name
     * @return \LwcMailer\Service\MailerServiceOptions
     */
    public function setDefaultFromName ($name)
    {
        $this->defaultFromName = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultFrom ()
    {
        return $this->defaultFrom;
    }

    /**
     * @param string $from
     * @return \LwcMailer\Service\MailerServiceOptions
     */
    public function setDefaultFrom ($from)
    {
        $this->defaultFrom = $from;
        return $this;
    }

    /**
     * @return \Zend\Mail\Transport\TransportInterface
     */
    public function getTransport ()
    {
        return $this->transport;
    }

    /**
     * @param string|TransportInterface $transport
     * @throws \InvalidArgumentException
     * @return \LwcMailer\Service\MailerServiceOptions
     */
    public function setTransport ($transport)
    {
        // allow injection and exit early
        if($transport instanceof TransportInterface) {
            $this->transport = $transport;
            return $this;
        }

        $adapter = strtolower($transport);
        if($adapter == 'smtp') {
            $options = new SmtpOptions($this->getTransportOptions());
            $transport = new Smtp($options);
        } else if($transport == 'file') {
            $options = new FileOptions($this->getTransportOptions());
            $transport = new File($options);
        } else if($transport == 'sendmail') {
            $transport = new Sendmail();
        }

        if(!$transport instanceof TransportInterface) {
            throw new \InvalidArgumentException('Could not set transport!');
        }

        $this->transport = $transport;
        return $this;
    }

    /**
     * @param array $options
     * @return \LwcMailer\Service\MailerServiceOptions
     */
    public function setTransportOptions (array $options)
    {
        $this->transportOptions = $options;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getTransportOptions ()
    {
        return $this->transportOptions;
    }
}