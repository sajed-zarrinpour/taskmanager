<p align="center"><a href="https://github.com/sajed-zarrinpour/taskmanager" target="_blank">TaskMan</a></p>


## About
A Simple Task manager.

## Installation
Clone Repo
```
git clone https://github.com/sajed-zarrinpour/taskmanager.git
```
Install dependencies
```
composer install
```
Set up environments
```
cp .env.example .env
```
and use the following if you are planing to follow these instructions for sail
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

Generate Security keys
```
sail artisan key:generate
```
Database migrations
```
sail artisan migrate
```
Run the application
```
sail up -d
```

tests
```
sail artisan test
```