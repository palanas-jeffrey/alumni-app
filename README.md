
# Alumni Connect

The App is a web-based platform designed to connect alumni, share events, enable donations, and conduct tracer studies. It provides a centralized hub for alumni engagement, event management, donation tracking, and data collection to support institutional growth.
Tech Stack: Laravel, Livewire, JavaScript, HTML, CSS, MariaDB, PayMongo API.


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`APP_NAME`

`APP_URL`

`DB_CONNECTION`

`DB_HOST`

`DB_PORT`

`DB_DATABASE`

`DB_USERNAME`

`DB_PASSWORD`

`MAIL_MAILER`

`MAIL_HOST`

`MAIL_PORT`

`MAIL_USERNAME`

`MAIL_PASSWORD`

`MAIL_ENCRYPTION`

`MAIL_FROM_ADDRESS`

`MAIL_FROM_NAME`

`VITE_APP_NAME`

`PAYMONGO_SECRET_KEY`

`PAYPAL_MODE`

`PAYPAL_SANDBOX_CLIENT_ID`

`PAYPAL_SANDBOX_CLIENT_SECRET`


## Run Locally


Go to the project directory

```bash
  cd cci-alumni-app
```

Install dependencies

```bash
  composer install
  npm install
```

Start the server

```bash
  composer run dev
```

Database server

Make sure the database server is running.

Create symlink to show images

```bash
  php artisan storage:link 
```

## Documentation references

[Laravel](https://laravel.com/docs/13.x)

[Livewire](https://livewire.laravel.com/docs/4.x/quickstart)

[PayMongo](https://docs.paymongo.com/)

[PayPal](https://developer.paypal.com/home/)
