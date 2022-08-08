## PHP Example App

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

    192.168.56.56 php-example-app.local

and enjoy!

## TODO

- [ ] Improve request / response handling
- [ ] Improve login / registration handling
- [ ] Improve data fetching
    - [ ] Use limitation for data fetching
    - [ ] Use models for data holding
- [ ] Add migration
- [ ] Use more PHP 8 features
- [ ] Improve frontend with css framework like Tailwindcss
- [ ] ... TBD (to be defined) ...
