# reciteMe

In order to run my Laravel project, please clone the repo and take the following steps.
    
   - php artisan serve // local server for speed @ 127.0.0.1:8000
   - Check .env and config/database.php are matching up with local instance of db set up
   - php artisan migrate
   - composer update/install
   - Probably won't need to from the start but always handy to run:
       - php artisan cache:clear, config:clear, route:clear
