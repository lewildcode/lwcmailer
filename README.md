LwcMailer
=========

ZF2 module for sending emails

To install via composer, add the repository to your composer.json

    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "LwcMailer",
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
        "LwcMailer": "1.*"
    }

Add the "LwcMailer" module to the config/application.config.php. Copy the .dist config file to your config/autoload/ directory and modify as needed.
