# Laravel + Vue.js Installation Guide

This guide helps you set up a Laravel + Vue.js single-page application (SPA) from scratch.

---

## Prerequisites

Make sure you have the following installed:

- PHP >= 8.2
- Composer
- Node.js & NPM
- Laravel CLI >= 11.\*
- MySQL or any supported DB

---

## 1. Clone the Project

```bash
git clone https://github.com/elangeloferrer/task-management-system.git
```

```bash
cd task-management-system
```

## 2. Install PHP Dependencies

```bash
composer install
```

## 3. Install JavaScript Dependencies

```bash
npm install
```

## 4. Environment Setup

##### Copy .env.example

```bash
cp .env.example .env
```

Edit the .env file and set your database credentials and app URL.

##### Generate the application key

```bash
php artisan key:generate
```

## 5. Run Migrations (Optional: with Seeders)

```bash
php artisan migrate --seed
```

## 7. Compile Frontend Assets

```bash
npm run dev
```

## 8. Start Laravel Development Server

```bash
php artisan serve
```

---

You're all set — your **Laravel** + **Vue.js** (Task Management System) project is now fully installed and ready to run! 🚀

## Documentation

[Postman Collection](./TMS.postman_collection.json)

## Run Test Cases

```bash
php artisan test --env=testing --filter=TaskTest::testCreateTask
```

```bash
php artisan test --env=testing --filter=TaskTest::testGetTask
```

```bash
php artisan test --env=testing --filter=TaskTest::testUpdateTask
```

```bash
php artisan test --env=testing --filter=TaskTest::testDeleteTask
```

## Run Scheduled Command Manually

```bash
php artisan queue:work
```

```bash
php artisan app:delete-old-tasks-command
```
