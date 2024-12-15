## Getting started

To make it easy for you to get started with this project, Just do these steps below.


## Clone this repository

```
cd desire directory
git clone <address>
```

## Install all requirements
```
composer install
composer require maatwebsite/excel
php artisan key:generate
```

## .env.example
```
remove .example and uncomment and set up your data base

DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

```

## Mailtrap config
```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=0e995676f92bbc
MAIL_PASSWORD=db9ece740627aa
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

```


## Insert data By Seeder
```
php artisan db:seed
```

## Default Admin User
```
username: admin
password: admin
```

## Export posts as Excel
```
php artisan export:blog-posts
php artisan export:blog-posts --all
```


## After defining publish time
```
publish post(Job)
php artisan queue:work
Note that mailtrap can not send email to more than 5 users 
```




### That's it Enjoy :)
