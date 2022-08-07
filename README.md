## workshoptask

This project demonstrates in a very simple way how to quickly develop a small application in PHP 7/8 without a framework or a cms system.

Furthermore, I developed it to keep myself up to date in php development.

## To run

You can start the application if you call the following commands

    cp .env.example .env
    composer install
    php -S localhost:8080 -t public/

or you can use Vagrant

    cp .env.example .env
    composer install
    vagrant up

and add the following line to your hosts file

    192.168.56.56 project-workshoptask.local

and enjoy!
