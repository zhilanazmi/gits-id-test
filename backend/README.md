# Book Catalog API - Backend

REST API untuk Digital Book Catalog Management Platform. Dibangun dengan Laravel 12 dan JWT Authentication.

## Tech Stack

- **Framework:** Laravel 12.x
- **PHP:** 8.2+
- **Database:** MySQL 8.x
- **Authentication:** JWT (php-open-source-saver/jwt-auth)
- **ORM:** Eloquent

## Requirements

- PHP >= 8.2
- Composer
- MySQL 8.x (atau MariaDB 10.x)

## Setup & Installation

### 1. Clone & Install Dependencies

```bash
cd backend
composer install
```

### 2. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

Edit file `.env` sesuai konfigurasi database lokal:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book_catalog
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Buat Database

Buat database MySQL dengan nama `book_catalog`:


### 4. Jalankan Migration

```bash
php artisan migrate
```

### 5. Jalankan Seeder (Data Demo)

```bash
php artisan db:seed
```

Seeder akan membuat:
- 2 Users 
- 10 Authors (datanya dummy dari Faker)
- 5 Publishers (datanya dummy dari Faker)
- 30 Books (berbagai author & publisher)

### 6. Start Development Server

```bash
php artisan serve --port=8000
```

API akan berjalan di: `http://localhost:8000`

## Demo Credentials

- admin@example.com | password123 | Admin
- user@example.com | password123 | User

## API Endpoints

API Base URL: `http://localhost:8000/api`

## Useful Commands

```bash
# Reset database (drop all tables, migrate, seed)
php artisan migrate:fresh --seed

# Clear all cache
php artisan optimize:clear

# List all routes
php artisan route:list

# Run tests
php artisan test
```
