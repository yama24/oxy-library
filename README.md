
# OXY Library

A simple school library with auth system and CRUD


## Made on

 - Laravel 9
 - Bootstrap 5
 - MySQL


## Installation

Make sure this:

- PHP version is 8 or above
- MySQL driver for PHP already installed
- Composer already installed

Clone the repo

```bash
git clone https://github.com/yama24/oxy-library.git
```

or if you have Github CLI installed

```bash
gh repo clone yama24/oxy-library
```

Get into the folder

```bash
cd oxy-library
```

Download the dependencies

```bash
composer install
```

Create .env file

```bash
cp .env.example .env
```

Generate APP_KEY

```bash
php artisan key:generate
```

Open .env file and setup the value

- APP_URL=(http://localhost/8000 or domain)
- DB_DATABASE=(your MySQL database name)
- DB_USERNAME=(MySQL username)
- DB_PASSWORD=(MySQL user password)

and for email please set according to your email 

for test, I suggest to use [Mailtrap.io](https://mailtrap.io/)

migrate & seed database 

```bash
php artisan migrate:fresh --seed
```

Link storage location 

```bash
php artisan storage:link
```

run the local server

```bash
php artisan serve
```

for default admin user :
| Email | Password     |
| :-------- | :------- |
| `admin@admin.com` | `admin` |
