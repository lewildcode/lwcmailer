<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'LwcMailer\Service\Mailer' => 'LwcMailer\Service\MailerServiceFactory'
        )
    ),
);