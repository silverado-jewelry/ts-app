# Laravel 11 application - ts-app

This is a Laravel 11 application for Twój Startup. 
Application includes a basic admin panel for articles management written on Filament 3x and API layer for CRUD operations with articles, user authentication etc.
Full-text search is implemented using Laravel Scout.
Follow the instructions below to set up the project locally.

## Requirements

- **PHP >= 8.1**
- **Composer** (Dependency Manager)
- **MySQL >= 5.7** or another compatible database engine (PostgreSQL, SQLite, SQL Server)
- **Node.js >= 18.x** (for front-end asset management)
- **NPM >= 9.x** or **Yarn**
- Required PHP Extensions:
    - BCMath
    - Ctype
    - Fileinfo
    - JSON
    - Mbstring
    - OpenSSL
    - PDO
    - Tokenizer
    - XML

## Installation Instructions

### 1. Clone the Repository

```
git clone https://github.com/silverado-jewelry/ts-app.git
```

### 2. Open project directory
```
cd ts-app
```

### 3. Install Composer Dependencies

```bash
composer install
```

### 3. Setup local environment

```bash
cp .env.example .env
```
Edit the .env file to set your database connection:
    
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Run Database Migrations and load dummy data from Seeders

```bash
php artisan migrate --seed
```

### 5. Install Npm packages and compile assets

```bash
npm install && npm run build
```

### 6. Serve the application

```bash
php artisan serve
```

The application will be available at http://localhost:8000.

## Unit and Feature Tests

To run the tests, execute the following command:

```bash
php artisan test
```

## REST API Documentation

The REST API documentation is available at https://documenter.getpostman.com/view/20152906/2sAXjRVpVX.

Download the Postman collection from [here](https://www.postman.com/abamka/workspace/public/collection/20152906-c1883a9c-30f7-462b-9b07-5ee221f74e59?action=share&creator=20152906).