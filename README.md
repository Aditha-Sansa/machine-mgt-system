# Machine Management System

This repository contains both the backend (Laravel) and frontend (Vue) solutions for the Machine Management System assessment. The two projects are kept together in the same repository under the `backend/` and `frontend/` directories so the entire solution can be submitted to a single git repository.

## Contents

- `backend/` — Laravel 12 application (PHP 8.2+). Uses MySQL for normal runtime and SQLite for running tests.
- `frontend/` — Vue 3.5 application using Vite, Pinia, and Tailwind CSS 4.

---

## Requirements

- PHP 8.2 or higher
- Composer (for backend dependencies)
- MySQL server (local) — backend uses MySQL in normal runs
- Node.js 20 or higher (recommended)
- npm (or yarn)

Notes:
- Laravel version: 12
- Backend tests run against SQLite (configured in `phpunit.xml` / environment)

---

## Setup & Run (Windows / cmd.exe)

### Backend

1. Open a terminal and change into the backend directory:

```bat
cd backend
```

2. Install PHP dependencies:

```bat
composer install
```

3. Create your environment file (if not already present) and generate app key:

```bat
copy .env.example .env
php artisan key:generate
```

4. Update `.env` with your database connection details (MySQL). Example `.env` variables to check:

- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=your_database`
- `DB_USERNAME=your_username`
- `DB_PASSWORD=your_password`

5. Run migrations and seeders (if you want seeded credentials & demo data):

```bat
php artisan migrate --seed
```

6. Serve the application locally:

```bat
php artisan serve --host=127.0.0.1 --port=8000
```

The API base URL will be something like `http://127.0.0.1:8000`.

### Frontend

1. Open a new terminal and change into the frontend directory:

```bat
cd frontend
```

2. Install node dependencies:

```bat
npm install
```

3. Create a `.env` file in `frontend/` (or update it) and point the frontend at the running backend API. Example entry:

```
VITE_API_URL=https://{your_localhost_url}/api/v1
```

For local testing with the default Laravel serve above, an example would be:

```
VITE_API_URL=http://127.0.0.1:8000/api/v1
```

4. Start the frontend dev server:

```bat
npm run dev
```

Open the app in your browser at the URL printed by the Vite dev server (usually `http://localhost:5173`).

---

## Environment variables summary

Backend: copy `.env.example` to `.env` and set DB credentials and any other keys. Ensure `APP_URL` matches the host you use when running the server.

Frontend: set `VITE_API_URL` in `frontend/.env` to point at your running backend (include `/api/v1` path).

---

## Features implemented

Backend (API):
- User authentication (API endpoints)
- Machines CRUD (index, show, create, update, delete)
- Machine hour logs: add hours, reset hours, list history

Frontend (UI):
- User login (consumes backend auth API)
- Machines CRUD pages and forms

Note: per the instructions, reset operations were implemented on the backend but intentionally not wired into the frontend UI (see assumptions below).

---

## Assumptions I have made

1. Its unclear what the Reset Count column in machine index page is for since it has a hour value. For this assessement I assume this should be how much times the machine hours has been reset.
2. The UI has inconsistent labels, the specification referenced both "Model"/"Brand" and "Category"/"Brand" so this implementation uses `category` & `brand` consistently.
3. Since there should be a upper limit on the hour value when adding the hour logs, I assumed the user can add upto 72 of a value in a single request.
4. Users do not need to own their own records, records (machines, logs) are not scoped to a specific user's `user_id` for this demo.
5. Authentication for demonstration is seeded, the demo user credentials are seeded into the database so signup is not required while demonstrating login.
6. Under the backend features of the requirements, its mentioned to implement api's for user auth, machines CRUD, reset operation hours. But for the frontend, its mentioned only user auth, machines CRUD. So I assumed reset operations are not needed for frontend.

---

## Seeded/demo credentials

A demo user is seeded during database seeding to allow immediate login and evaluation of the frontend without needing to sign up. Check `database/seeders/DatabaseSeeder.php` or the factory files for exact credentials used for the seeded user.

---

## API notes

- API base: `{APP_URL}/api/v1` (or `VITE_API_URL` from the frontend environment)
- Common endpoints:
  - `POST /api/v1/auth/login` — login returns token and user
  - `POST /api/v1/auth/logout` — logout
  - `GET /api/v1/machines` — list machines (paginated)
  - `POST /api/v1/machines` — create machine
  - `GET /api/v1/machines/{id}` — show machine
  - `PUT /api/v1/machines/{id}` — update machine
  - `DELETE /api/v1/machines/{id}` — delete machine
  - `POST /api/v1/machines/{id}/hours` — add hours
  - `POST /api/v1/machines/{id}/reset` — reset hours
  - `GET /api/v1/machines/{id}/history` — hour history


---

## Tests

To run tests (Laravel/PHPUnit):

```bat
cd backend
php artisan test
```

Tests are configured to run using SQLite (see `phpunit.xml` and `.env.testing` if present).

---
