## Serving the website

### Using Docker:

- git clone https://github.com/HaidarChaitoMena/webtask.git
- cd webtask
- cp .env.example .env
- composer install
- ./vendor/bin/sail up
- ./vendor/bin/sail php artisan migrate
- ./vendor/bin/sail php artisan db:seed
- ./vendor/bin/sail npm i
- ./vendor/bin/sail npm run build
- visit http://localhost\
  This will build the containers and serve them on localhost and migrate and seed some default db values.\
  to login with the admin email as admin@example.com and the password is password. \
  all the users share the same password as the admin for testing purposes.

### Manual

you must have a mysql server running

- git clone https://github.com/HaidarChaitoMena/webtask.git
- cd webtask
- cp .env.example .env
- edit .env file and change
-
    * DB_HOST to localhost
-
    * DB_USERNAME to the mysql username or root by default
-
    * DB_PASSWORD to the mysql password or empty by default
- composer install
- php artisan migrate --force
- php artisan db:seed
- npm i
- npm run build
- php artisan serve
- visit http://localhost

