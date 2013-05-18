<?php

namespace LwcMailerTest\Service;

use LwcMailer\Service\MailerServiceOptions;

class MailerServiceOptionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MailerServiceOptions
     */
    protected $options;

    protected function setUp ()
    {
        $this->options = new MailerServiceOptions();
    }

    public function testSetDefaultSender ()
    {
        $email = 'me@example.com';
        $name = 'Sender name';

        $this->options->setDefaultFrom($email)
                      ->setDefaultFromName($name);

        $this->assertSame($email, $this->options->getDefaultFrom());
        $this->assertSame($name, $this->options->getDefaultFromName());
    }

    public function testChangeEncoding ()
    {
        $encoding = 'ASCII';
        $this->options->setEncoding($encoding);

        $this->assertSame($encoding, $this->options->getEncoding());
    }

    /**
     * @dataProvider dataProviderTransports
     * @param string $transportString
     */
    public function testSetTransportViaString ($transportString)
    {
        $this->options->setTransport($transportString);
        $this->assertInstanceOf('Zend\Mail\Transport\TransportInterface',
                $this->options->getTransport());
    }

    /**
     * @return array
     */
    public function dataProviderTransports ()
    {
        return array(
            array('sendmail'),
            array('smtp'),
            array('file')
        );
    }

    public function testSetRecipients ()
    {
        $recipientsTo = array(
            'me1@example.com' => 'its me',
            'me2@example.com' => 'me again'
        );
        $this->options->setRecipients($recipientsTo);

        $this->assertCount(2, $this->options->getRecipients());
    }
}