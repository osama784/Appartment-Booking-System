# Appartment Booking System

**University project** — an apartment booking system built with Laravel.

An early-stage REST API backend for an apartment booking platform. The API
authentication flow is implemented and the database schema for the domain is
in place; the booking and management endpoints are still to be built. The
intended API surface is sketched in [`plan.txt`](plan.txt).

## What's implemented

**API authentication** (Laravel Sanctum tokens) — `routes/api.php`,
`app/Http/Controllers/AuthController.php`:

- `POST /api/auth/register` — register as `tenant` or `owner` (phone,
  first/last name, birth date, password, optional profile and ID images)
- `POST /api/auth/login` — log in with phone + password, returns a bearer token
- `POST /api/auth/logout` — revoke the current token (requires authentication)
- `GET /api/auth/user` — return the authenticated user (requires authentication)
- `GET /api/test` — health-check endpoint

**Accounts and roles**

- Three roles: `admin`, `owner`, `tenant` (`app/Enums/UserRole.php`);
  self-registration cannot create an `admin`
- Account statuses — accounts carry a `pending` / `approved` / `rejected`
  status, and `pending` or `rejected` accounts cannot log in. (Setting a user
  to `approved` has no endpoint yet; `register` is currently broken — see
  Known issues.)

**Database schema** (`database/migrations/`) — tables for users, apartments,
apartment images, bookings, booking update requests, reviews, conversations,
messages, payments, notifications and favorite apartments.

## What's not implemented yet

- Apartment, booking, review, messaging, favorite, payment and admin
  user-management endpoints (listed in `plan.txt` but not yet built)
- Any custom web UI — only the default Laravel welcome page is served at `/`

## Tech stack

- PHP 8.2+ and Laravel 12
- Laravel Sanctum 4 for API tokens; Laravel Tinker
- SQLite by default (see `.env.example`); MySQL/MariaDB connections are also
  configured in `config/database.php`
- Vite + Tailwind CSS for asset building (default setup only)
- PHPUnit 11 for tests

## Getting started

Requirements: PHP 8.2+ and Composer. The default `.env.example` uses SQLite.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

The API is then served at `http://localhost:8000/api`.

## Known issues

- `php artisan migrate` does not complete on a fresh database with the default
  SQLite setup: the migration that drops the `email` column fails because its
  unique index still exists, and several later migrations declare foreign keys
  for columns they do not define.
- `php artisan db:seed` fails because the seeder and the user factory still
  reference the removed `name` and `email` user columns.
- The `register` endpoint is implemented but currently fails at runtime: the
  user's `status` is not set (a required column) and the controller calls a
  `serialize()` method that does not exist on the `User` model.
  `login`, `logout` and `auth/user` work.

## Tests

```bash
php artisan test
```

The default example tests pass.
