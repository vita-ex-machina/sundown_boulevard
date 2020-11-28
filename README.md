# Sundown Boulevard

👋 Hello world! 

# Setup

If you are looking at this repository, you properly already know what you are doing. 😎

**#notestoself**

## Git clone

Clone the repository by running the following command in terminal: 

    git clone https://github.com/vita-ex-machina/sundown_boulevard.git


## .env file

Open .env file and make sure  DB_PORT and DB_DATABASE are set correctly.

E.g.:

    DB_PORT=8889
    DB_DATABASE=sundown_boulevard
    


## Install bootstrap 

    php artisan ui bootstrap
    npm install
    npm run dev

## Run migrations

    php artisan migrate

## Seed database

    php artisan db:seed


## Start server 

Start the server with the command

    php artisan serve





