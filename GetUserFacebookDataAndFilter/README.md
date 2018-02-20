

-------------------------------------
Get user Facebook data and Filter
-------------------------------------

It provides API service that you can use as cronjob from fetching Facebook data and store in local database.
It provides a interface to filter data.

--------------------------------




2. Download project dependencies <br />
composer install

3. Create database with name "oddity" 

4. Create tables in database and user table fill with default user <br />
php artisan migrate:fresh --seed

5. Set these facebook Api constants in .env file <br />
FB_API_ID =  <br />
FB_APP_SECRET =  <br />

6. Start Application server <br />
php artisan serve


Application Pages
-------------------------

losthost:8000/login <br />
It will give you link to login from facebook.

losthost:8000/cronjob <br />
It will run your cron fucntion

losthost:8000/oddity <br />
it will show you content with filter
