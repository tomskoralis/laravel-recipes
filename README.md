# Recipes website

## Technologies used

- PHP 8.2
- mySQL 8.0
- Composer 2.4
- Node.js npm 8.19
- Laravel 9.49

## Instructions to run the website

1. Clone this repository and navigate to its directory by using the commands:
    ```
    https://github.com/tomskoralis/laravel-recipes
    cd laravel-recipes/
    ```
2. Install the required packages using the commands:
    ```
    composer install
    npm install
    ```
3. Make a copy of the `.env.example` and rename the copy to `.env` by using the command:
    ```
    cp .env.example .env
    ```
4. Create a new mySQL database schema.
5. Enter the mySQL credentials in the `.env` file. The variables are: `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
6. Run the database migrations and seed the database using the command:
    ```
    php artisan migrate:fresh --seed
    ```
7. Run the Vite development server using the command:
    ```
    npm run dev
    ```
8. Start the local development server using the command in another terminal window:
    ```
    php artisan serve
    ```
9. Test the website by opening it in the browser using the URL http://127.0.0.1:8000
