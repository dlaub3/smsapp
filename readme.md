## About Smsapp

Smsapp is a service for sending group text messages via the web or by text. It It is built on Laravel 5.4 and uses the following services.

- Twilio: A Twilio account is required to send and receive text messages.

- Algolia: Algolia is the default search provider for Laravel applications. However you are free to swap this for one of the alternatives such as TNTSearch.

## To start using Smsapp
- ```git clone https://github.com/dlaub3/smsapp.git```
- ```cd smsapp```
- ```composer install ```

Move the .env.example to .env and configure your Algolia and Twilio credentials.

  - TWILIO_ACCOUNT_SID =
  - TWILIO_AUTH_TOKEN =
  - TWILIO_NUMBER =


  - SCOUT_DRIVER=
  - ALGOLIA_APP_ID=
  - ALGOLIA_SECRET=

Additionally Smsapp uses:
  - APP_URL=
  - APP_NAME=

Setup the MySQL or MariaDB database connection using the instructions for Laravel. After the database connection is setup, run:

 - ```php artisan migrate ```

 - ```php artisan key:generate```

If you are using docker-compose you can run ```docker-compose exec php-fpm bash```. Then cd to the project root and run the migration commands.

## Development

Run either:
```npm install``` or ```yarn```.

The project comes with the following configured.
- Bootstrap
- [Bootstrap Material Design](https://github.com/FezVrasta/bootstrap-material-design)

Of course Larvel itself has:
  - jQuery
  - Vue.js
  - Axios

All of this is run through Laravel Mix which is built on Webpack. So please refer to the Laravel documentation for more information.

## Notes

For analytics you can create a file called analytics-scripts.js at the project root. All scripts placed in this file will be included in /resources/views/layouts/app.blade.php. They will be included inline in the html. So make sure you use ```<script>``` tags. And depending on your project structure you may need to change the path in app.blade.php

To setup Spark Post email set the following in the .env file.  


SPARKPOST_SECRET=

MAIL_DRIVER=sparkpost

MAIL_FROM_ADDRESS=you@your-sparkpost-sending-domain

MAIL_FROM_NAME=your-website-name  


If you are using basic authentication with your web server, then in SmsController you will need to set the ```$url``` to  yourdomain.com/twilio/sms in order for Twilio to authenticate properly. Otherwise the username@password part of the request will cause an authentication error.

See the [Twilio Security Docs](https://www.twilio.com/docs/api/security) for more details.


## Todo
- Create unit and functional tests
- Enable progressive web app features

## Security Vulnerabilities

If you discover a security vulnerability within Smsapp. Please contact me via my
[blog](https://www.codejots.com/contact/)

## Code Style

[PSR-2 coding standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)

[PSR-4 coding standard](http://www.php-fig.org/psr/psr-4/)

## License

Smsapp is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
