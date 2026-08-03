# Realisasi Asesmen LSP

A Laravel-based web application to manage and monitor LSP assessment realization, including master data, internal/external assessment execution, and yearly target-vs-realization reporting.

## Table of Contents
- [Overview](#overview)
- [Core Features](#core-features)
- [Tech Stack](#tech-stack)
- [Data Model (High Level)](#data-model-high-level)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database and Initial Data](#database-and-initial-data)
- [Run the Application](#run-the-application)
- [Available Commands](#available-commands)
- [Testing](#testing)
- [UI Modules](#ui-modules)
- [API/Health Endpoint](#apihealth-endpoint)
- [Deployment Notes](#deployment-notes)

## Overview
This project helps teams track assessment activities against annual targets, with support for:
- Internal assessments (entity/band context)
- External assessments (location context)
- Dashboard KPIs and trend charts
- Recap reports by band and target realization

The app is built with Laravel 12, Blade, Tailwind CSS, and Alpine.js.

## Core Features
- **Authentication** (Laravel Breeze)
- **Master data management**
  - Assessees
  - Assessors
  - Schemes
- **Assessment management**
  - Internal assessment records
  - External assessment records
- **Dashboard analytics**
  - Total assessees, assessments, active assessors, active schemes
  - Monthly trend and target comparison
  - Internal vs external distribution
- **Reports**
  - Recap per band (`/laporan/rekap-band`)
  - Target vs realization (`/laporan/target-realisasi`)
- **Excel import pipeline** for bootstrap/operational data loading

## Tech Stack
- **Backend:** PHP 8.2+, Laravel 12
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Vite
- **Database:** SQLite (default local), PostgreSQL supported (`ext-pgsql` required)
- **Excel Processing:** `maatwebsite/excel`
- **Testing:** PHPUnit

## Data Model (High Level)
Main entities:
- `entities`
- `assessees` (internal/external type, band/location)
- `assessors`
- `schemes` (with scope)
- `assessments` (links assessee, assessor, scheme, plus dates/venues/notes)
- `assessment_targets` (yearly/monthly targets per internal entity or external location)

## Prerequisites
- PHP **8.2+**
- Composer
- Node.js + npm
- Database engine:
  - SQLite (quick local setup), or
  - PostgreSQL

## Installation
```bash
git clone <repository-url>
cd realisasi-asesmen-lsp
composer install
npm install
cp .env.example .env
php artisan key:generate
```

## Configuration
Update `.env` based on your environment.

### SQLite (default quick setup)
```env
DB_CONNECTION=sqlite
```
Then create the database file if needed:
```bash
touch database/database.sqlite
```

### PostgreSQL example
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

## Database and Initial Data
### Option A — Full automated setup (recommended)
Run migrations, seeders, and all Excel imports in one command:
```bash
php artisan app:setup --fresh
```
- `--fresh` resets all tables first.
- Without `--fresh`, it runs migrate + seed + import on current DB state.

### Option B — Manual setup
```bash
php artisan migrate --seed
```
Then run import commands one by one:
```bash
php artisan import:entities storage/app/data-entities.xlsx
php artisan import:schemes storage/app/data-schemes.xlsx
php artisan import:assessors storage/app/data-assessors.xlsx
php artisan import:assessees storage/app/data-assessees.xlsx
php artisan import:assessment-targets storage/app/data-assessment-targets.xlsx
php artisan import:assessments storage/app/data-assessments.xlsx
```

### Seeded Login User
`UserSeeder` creates one default user. For security, change this password immediately in non-local environments.

## Run the Application
### Development mode (recommended)
```bash
composer run dev
```
This runs Laravel server, queue listener, log tailing, and Vite concurrently.

### Alternative (separate terminals)
```bash
php artisan serve
npm run dev
```

## Available Commands
- `php artisan app:setup {--fresh}`
- `php artisan import:entities {file}`
- `php artisan import:schemes {file}`
- `php artisan import:assessors {file}`
- `php artisan import:assessees {file}`
- `php artisan import:assessment-targets {file}`
- `php artisan import:assessments {file}`

## Testing
```bash
composer test
```
or
```bash
php artisan test
```

## UI Modules
Sidebar modules:
- **Dashboard**
- **Data Master**
  - Daftar Asesi
  - Laporan Asesor
  - Laporan Skema
- **Realisasi Asesmen**
  - Internal
  - Eksternal
- **Laporan**
  - Rekap per Band
  - Target Realisasi

## API/Health Endpoint
- `GET /up` returns `200 OK` for health checks (useful for platform probes, e.g. Railway).

## Deployment Notes
- Set `APP_ENV=production` and `APP_DEBUG=false` in production.
- Configure a production-grade DB (typically PostgreSQL).
- Run:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```
- Ensure file permissions for `storage/` and `bootstrap/cache/` are correct.
