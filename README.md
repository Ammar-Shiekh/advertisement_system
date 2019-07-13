# Advertisements system

A system for controlling advertisements on multiple screens by multiple authorized clients. This project is based on laravel framework.

## Features

1. An administrator can set/update/remove clients' permissions for controlling advertisements on the available screens.
2. An authorized client can add an advertisement to a selected list of screens that he is authorized to publish on. The advertisement is defined by an image, and duration for each screen to be displayed on.
3. An authorized client can update/remove an advertisement that he published.
4. For each action (Adding/Updating/Removing an advertisement) an event is sent to the screen to make the process runs in real-time.
5. An API is available for screen devices to interact with, and only authenticated screens can have access to the API.

## Setup

1. Open terminal, and change directory to were you cloned the project `cd <PROJECT_NAME>` (example: `cd advertisements_system`).
2. Install composer dependencies (You should have [Composer](https://getcomposer.org/) installed). `composer install`.
3. Copy `.env` file `cp .env.example .env`.
4. Generate an app encryption key `php artisan key:generate`.
5. Create an empty database using the database tools you prefer.
6. Configure `.env` file to allow Laravel to connect to the database you created (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD`.
7. Configure `.env` file to set `BROADCAST_DRIVER` (for example: create an app using [Pusher](https://pusher.com/). then `BROADCAST_DRIVER=pusher` and set `PUSHER_APP_ID`, `PUSHER_APP_KEY`, `PUSHER_APP_SECRET` and `PUSHER_APP_CLUSTER` values in `.env` file to the values provided by pusher app you created. 
8. Migrate the database `php artisan migrate`.
9. Create the encryption keys needed to generate secure access tokens `php artisan passport:install`.
10. Seed the database with some accounts for testing `php artisan db:seed --class=InitSeed`. This will create the following accounts (All accounts have the same password `123456789`):
  * Administrator account (admin@system.com).
  * Publisher (client) accounts:
    * ahmad@system.com
    * usama@system.com
    * mohammad@system.com
  * Devices (screens):
    * Device 1
    * Device 2
    * Device 3
11. Run the server `php artisan serve`.

## Clients

1. [Java Pusher Client](https://github.com/Ammar-Shiekh/advertisement_system_java_client)
