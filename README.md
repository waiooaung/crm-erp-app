Mini CRM/ERP System
<p align="center"> <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"> </p> <p align="center"> <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Laravel Version"></a> <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a> </p>
About the Project

This is a mini CRM/ERP system built on Laravel with Filament Admin Panel. It allows you to:

Manage Users, Departments, Assets, and Issues

Track assigned assets and reported issues

Role-based access (Admin, Manager, Staff)

Real-time admin panel using Filament

Features

Admin panel at /admin

Custom welcome screen

Role-based user access

Seeded demo data for users, departments, assets, and issues

Fully functional CRUD for all entities

Requirements

PHP 8.1+

Composer

MySQL / MariaDB / PostgreSQL

Node.js & npm (for assets)

Installation & Setup

Clone the repository:

git clone <your-repo-url>
cd <your-project-folder>


Install dependencies:

composer install
npm install
npm run dev


Copy .env file and generate application key:

cp .env.example .env
php artisan key:generate

Database Setup

Create a database in MySQL (or your preferred DB)

Update .env with your DB credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_crm
DB_USERNAME=root
DB_PASSWORD=


Run migrations:

php artisan migrate


Seed the database with sample data:

php artisan db:seed


This will create:

Departments (HR, IT, Finance, Operations)

Users (Admin + Manager + Staff)

Sample Assets and Issues

Admin Panel

Access the admin panel at: http://localhost:8000/admin

Use seeded Admin user to login:

Email: admin@example.com
Password: password

Contributing

Contributions are welcome! Please follow Laravel’s Code of Conduct
.

License

This project is open-sourced software licensed under the MIT license
.

Commands Summary
# Install PHP dependencies
composer install

# Install JS dependencies
npm install
npm run dev

# Copy env and generate key
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Run the app locally
php artisan serve
