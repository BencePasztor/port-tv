## Requirements:

 - PHP 8.1
 - MYSQL 5.7

## Installation:

 1. Create a .env file and copy the contents of .env.example into it
 2. Open the .env and fill in the local database information(DB_...)
 3. Run `composer install`
 4. Run `npm install`
 5. Run `npm run build`
 6. Run `php artisan migrate`
 7. Run `php artisan schedule:fetch` to fetch today's schedule, or specify a date like `php artisan schedule:fetch 2024-02-27`
 8. Run `php artisan serve`
