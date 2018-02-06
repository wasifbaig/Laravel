

-------------------------------------
Get user Facebook data and Filter
-------------------------------------

It provides API service that you can use as cronjob from fetching Facebook data and store in local database.
It provides a interface to filter data.

--------------------------------


1. Install Laravel
composer global require "laravel/installer"

2. Download project dependencies
composer install

3. Create database with name "oddity" 

4. Create tables in database and user table fill with default user
php artisan migrate:fresh --seed

5. set these constants in .env file
##### facebook Api
FB_API_ID = 
FB_APP_SECRET = 
####


6. Start Application server
php artisan serve


Application Pages
-------------------------

call losthost:8000/login
It will give you link to login from facebook.

call losthost:8000/cronjob
It will run your cron fucntion

call losthost:8000/oddity
it will show you content with filter