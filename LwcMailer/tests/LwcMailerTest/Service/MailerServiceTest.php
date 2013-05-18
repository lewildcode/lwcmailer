<?php

namespace LwcMailerTest\Service;

use LwcMailer\Service\MailerService;
use LwcMailer\Service\MailerServiceOptions;

class MailerServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MailerService
     */
    protected $service;

    protected function setUp ()
    {
        $options = new MailerServiceOptions();
        $this->service = new MailerService($options);
    }

    public function testGetOptions ()
    {
        return $this->assertInstanceOf('LwcMailer\Service\MailerServiceOptions',
                $this->service->getOptions());
    }

    public function testCreateMailFailsWithoutDefaultSender ()
    {
        $this->setExpectedException('RuntimeException');

        $body = 'my mail body';
        $subject = 'test subject';
        $mail = $this->service->createMail($subject, $body);
    }

    public function testCreateMail ()
    {
        $this->service->getOptions()
             ->setDefaultFrom('me@example.com')
             ->setDefaultFromName('John Doe');

        $body = 'my mail body';
        $subject = 'test subject';
        $mail = $this->service->createMail($subject, $body);

        $this->assertInstanceOf('Zend\Mail\Message', $mail);
    }
}