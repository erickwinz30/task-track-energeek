# Task Tracker Monorepo

Aplikasi task tracker berbasis monorepo:

- `backend/` -> Laravel 12 + Sanctum (REST API)
- `frontend/` -> Vue 3 + Vite + Pinia (Dashboard UI)

## Tech Stack

- Backend: PHP 8.2, Laravel 12, MySQL/PostgreSQL, Sanctum
- Frontend: Vue 3, TypeScript, Vue Router, Pinia, Axios

## Quick Start

### 1. Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Backend berjalan di `http://localhost:8000`.

### 2. Frontend

```bash
cd frontend
pnpm install
pnpm dev
```

Frontend berjalan di `http://localhost:5173`.

## Akun Login Seeder

- Email: `admin@energeek.id`
- Password: `password123`

## API Penting

- `POST /api/login`
- `POST /api/logout` (auth)
- `GET /api/user` (auth)
- `GET /api/dashboard` (auth)

## Testing

Backend:

```bash
cd backend
php artisan test
```

Frontend:

```bash
cd frontend
pnpm build
```
