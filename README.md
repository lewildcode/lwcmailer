LwcMailer
===============

To install via composer, add the repository to your composer.json

    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "lwc/LwcMailer",
                "version": "1.0.0",
                "source": {
                    "url": "http://github.com/lewildcode/LwcMailer",
                    "type": "git",
                    "reference": "master"
                }
            }
        }
    ],

then add the package to the require block

    "require": {
        "lwc/LwcMailer": "1.*",
    }

Add the "LwcMailer" module to the config/application.config.php. Copy the .dist config file to your config/autoload/ directory and modify as needed.

Example:

    public function sendMailViaLwcMailer ()
    {
        $mailer = $this->getServiceLocator()->get('LwcMailer\Service\Mailer');
        $cfg = $mailer->getOptions();
        $mail = $mailer->createMail('My mail subject', 'mail body');
        $mailer->send($mail);
    }
