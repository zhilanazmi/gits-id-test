
- **Backend**: REST API Laravel dengan JWT Authentication
- **Frontend**: Web interface Laravel Blade yang connect ke Backend API

## Project Structure

```text
.
├── backend/
│   ├── app/Http/Controllers/
│   ├── app/Models/
│   ├── database/migrations/
│   ├── database/seeders/
│   ├── routes/api.php
│   ├── api-docs.yaml
│   ├── .env.example
│   └── README.md
├── frontend/
│   ├── app/Http/Controllers/
│   ├── app/Services/ApiService.php
│   ├── resources/views/
│   ├── routes/web.php
│   ├── .env.example
│   └── README.md
└── README.md
```

## Requirements

- PHP >= 8.2
- Composer
- MySQL 8.x atau MariaDB 10.x
- Browser modern

## Backend Setup

Masuk ke folder backend:

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

Sesuaikan konfigurasi database di `backend/.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book_catalog
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `book_catalog`, lalu jalankan migration dan seeder:

```bash
php artisan migrate
php artisan db:seed
```

Jalankan backend API:

```bash
php artisan serve --port=8000
```

Backend berjalan di:

```text
http://localhost:8000
```

API base URL:

```text
http://localhost:8000/api
```

## Frontend Setup

Buka terminal baru, masuk ke folder frontend:

```bash
cd frontend
composer install
cp .env.example .env
php artisan key:generate
```

Pastikan `frontend/.env` mengarah ke backend API:

```env
APP_URL=http://localhost:8080
API_BASE_URL=http://localhost:8000/api
```

Jalankan frontend:

```bash
php artisan serve --port=8080
```

Frontend berjalan di:

```text
http://localhost:8080
```

## Demo Credentials

Gunakan salah satu akun berikut setelah menjalankan seeder:

```text
admin@example.com | password123
user@example.com  | password123
```

## Main Pages

- `/login` - Login
- `/register` - Register
- `/dashboard` - Dashboard statistik
- `/authors` - List, search, pagination, create, edit, delete authors
- `/books` - List, search, filter author/publisher, pagination, create, edit, delete books
- `/publishers` - List, search, pagination, create, edit, delete publishers

## Environment Files

Setiap aplikasi memiliki file environment masing-masing:

- `backend/.env.example`
- `frontend/.env.example`

Copy masing-masing file menjadi `.env` sebelum menjalankan aplikasi.

## More Details

Lihat dokumentasi masing-masing aplikasi:

- `backend/README.md`
- `frontend/README.md`
