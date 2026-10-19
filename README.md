# Digitelnusa Inventory

Office asset inventory web application built with Laravel, Blade, Tailwind CSS v4, Alpine.js, and MySQL.

**English** | [Bahasa Indonesia](README.id.md)

## Overview

Digitelnusa Inventory helps an office record, track, and report its assets in one place: what each item is, where it is, who uses it, what condition it is in, and when it is due for maintenance.

## Features

- **Dashboard**: summary cards (total assets, assets needing attention, active and overdue maintenance), an asset-addition trend (last 30 days vs the previous 30 days), a 7-day maintenance schedule chart, an on-time maintenance completion gauge (target 80%), assets per category, and a paginated table of the latest assets. All charts are plain SVG and CSS, with no charting library.
- **Asset management**: create, edit, and delete assets (soft delete), unique asset codes, condition status (Baik, Rusak Ringan, Rusak Berat), quantity, user and location, purchase date and price, serial number, specification, multiple photos with a cover image, and a detail page.
- **Handovers**: digital and physical handover forms, and asset returns.
- **Maintenance**: schedules with due dates, priority, recurrence, cost, vendor details, documents and photos, and a "mark as done" action. Status (scheduled, overdue, done) is derived automatically.
- **Categories**: managed from the Settings page, each with a unique code.
- **Reports**: asset reports with PDF and Excel export.
- **Settings**: company information.
- **Authentication**: login and profile management (Laravel Breeze).

## Tech Stack

- Laravel (PHP 8.4)
- Blade templates
- Tailwind CSS v4 (design tokens live in the `@theme` block of `resources/css/app.css`)
- Alpine.js
- Vite
- MySQL

## Requirements

- PHP 8.4
- Composer
- Node.js and npm
- MySQL (for example via XAMPP)

## Getting Started

```bash
# 1. Clone the repository and enter the folder
git clone https://github.com/Zanuraen/inventory_dgn.git
cd inventory_dgn

# 2. Install PHP and JavaScript dependencies
composer install
npm install

# 3. Create the environment file (PowerShell: Copy-Item .env.example .env)
cp .env.example .env

# 4. Generate the application key
php artisan key:generate

# 5. Create an empty MySQL database, then set the DB_* values in .env

# 6. Create the database tables
php artisan migrate

# 7. Make uploaded photos publicly reachable
php artisan storage:link

# 8. Start the frontend build and the local server (two terminals)
npm run dev
php artisan serve
```

Then open `http://127.0.0.1:8000`. Keep `npm run dev` running, otherwise new Tailwind classes are not compiled.

## Project Structure

| Path | Purpose |
| --- | --- |
| `app/Http/Controllers` | Request handling for assets, maintenance, categories, reports, and settings |
| `app/Models` | Eloquent models (`Asset`, `Maintenance`, `Category`, and others) |
| `resources/views` | Blade views, grouped by feature |
| `resources/views/components` | Reusable components (`ui`, `charts`, `dashboard/partials`) |
| `resources/css/app.css` | Tailwind v4 setup and design tokens |
| `routes/web.php` | Application routes |

## Notes

- The interface language is Indonesian.
- Dashboard figures are computed in `DashboardController` and passed to small, reusable Blade components.
