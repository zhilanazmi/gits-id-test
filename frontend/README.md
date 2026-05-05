# Book Catalog Web - Frontend

Web client untuk Digital Book Catalog Management Platform. Dibangun dengan Laravel 12 Blade dan template WowDash Tailwind Admin.

## Tech Stack

- **Framework:** Laravel 12.x (Blade Templating)
- **CSS Framework:** TailwindCSS (via WowDash template)
- **HTTP Client:** Laravel Http Facade (Guzzle)
- **UI Template:** WowDash Tailwind Admin

## Requirements

- PHP >= 8.2
- Composer
- Backend API harus berjalan di `http://localhost:8000`

## Setup & Installation

### 1. Install Dependencies

```bash
cd frontend
composer install
```

### 2. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` jika perlu mengubah URL API backend:

```env
API_BASE_URL=http://localhost:8000/api
APP_URL=http://localhost:8080
```

### 3. Start Development Server

```bash
php artisan serve --port=8080
```

Web client akan berjalan di: `http://localhost:8080`

> **Penting:** Pastikan backend API sudah berjalan di `http://localhost:8000` sebelum mengaksess frontend.

## Cara Menggunakan

### 1. Pastikan Backend Berjalan

```bash
cd ../backend
php artisan serve --port=8000
```

### 2. Jalankan Frontend

```bash
cd ../frontend
php artisan serve --port=8080
```

### 3. Akses Aplikasi

Buka browser dan akses: `http://localhost:8080`

### 4. Login

Gunakan kredensial demo:

- admin@example.com | password123
- user@example.com | password123

## Halaman yang Tersedia

- Login | `/login` | Form login
- Register | `/register` | Form registrasi user baru
- Dashboard | `/dashboard` | Overview statistik (jumlah buku, penulis, penerbit)
- Authors List | `/authors` | Tabel daftar penulis + search + pagination
- Author Form | `/authors/create`, `/authors/{id}/edit` | Form tambah/edit penulis
- Books List | `/books` | Tabel daftar buku + filter + pagination
- Book Form | `/books/create`, `/books/{id}/edit` | Form tambah/edit buku
- Publishers List | `/publishers` | Tabel daftar penerbit + search + pagination
- Publisher Form | `/publishers/create`, `/publishers/{id}/edit` | Form tambah/edit penerbit



## Struktur Project

```
frontend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php        # Login/Register/Logout
│   │   │   ├── DashboardController.php   # Dashboard stats
│   │   │   ├── AuthorController.php      # CRUD Authors
│   │   │   ├── BookController.php        # CRUD Books
│   │   │   └── PublisherController.php   # CRUD Publishers
│   │   └── Middleware/
│   │       ├── AuthenticateApi.php       # Check JWT in session
│   │       └── RedirectIfAuthenticated.php
│   ├── Providers/
│   │   └── AppServiceProvider.php        # Register ApiService
│   └── Services/
│       └── ApiService.php                # HTTP client wrapper
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php                 # Main dashboard layout
│   │   └── auth.blade.php               # Auth pages layout
│   ├── partials/
│   │   ├── sidebar.blade.php            # Sidebar navigation
│   │   ├── header.blade.php             # Top navbar
│   │   └── footer.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── dashboard/
│   │   └── index.blade.php
│   ├── authors/
│   │   ├── index.blade.php              # List + pagination
│   │   └── form.blade.php              # Create/Edit form
│   ├── books/
│   │   ├── index.blade.php
│   │   └── form.blade.php
│   └── publishers/
│       ├── index.blade.php
│       └── form.blade.php
├── public/assets/                        # WowDash template assets
│   ├── css/
│   ├── js/
│   ├── images/
│   ├── fonts/
│   └── webfonts/
├── routes/web.php
└── .env.example
```


## Troubleshooting

### "Failed to fetch" errors
- Pastikan backend API berjalan di `http://localhost:8000`
- Cek `API_BASE_URL` di file `.env`

### Session expired / redirect ke login
- JWT token berlaku 60 menit
- Login ulang jika token sudah expired

### Halaman blank / error 500
- Jalankan `php artisan optimize:clear`
- Cek file `storage/logs/laravel.log` untuk detail error
