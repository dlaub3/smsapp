## About Smsapp

Smsapp is a service for sending group text messages via the web or by text. It It is built on Laravel 5.4 and uses the following services.

- Twilio: A Twilio account is required to send and receive text messages.

- Algolia: Algolia is the default search provider for Laravel applications. However you are free to swap this for one of the alternatives such as TNTSearch.

## To start using Smsapp

Clone the repo and ```cd smsapp ```
then ```composer install ```.

Move the .env.example to .env and configure your Algolia and Twilio credentials.

  - TWILIO_ACCOUNT_SID =
  - TWILIO_AUTH_TOKEN =
  - TWILIO_NUMBER =


  - SCOUT_DRIVER=
  - ALGOLIA_APP_ID=
  - ALGOLIA_SECRET=

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


## Security Vulnerabilities

If you discover a security vulnerability within Smsapp. Please pm me on github.

## Code Style

[PSR-2 coding standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)

[PSR-4 coding standard](http://www.php-fig.org/psr/psr-4/)


## License

Smsapp is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
