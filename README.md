# Clothing Shop ERP Management System

A Laravel 11 web-based ERP system for a clothing shop, built per the
"Enterprise Software Development" assignment specification. Implements
Product, Sales, Customer, and Reports modules with role-based access
control for Admin, Cashier, and Manager users.

## Tech Stack
- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Blade templates, Bootstrap 5, vanilla JavaScript, Bootstrap Icons
- **Database:** MySQL

## Features
- **Authentication:** Session-based login with role-based middleware (`admin`, `cashier`, `manager`)
- **Product Management:** Add / edit / delete / view products with stock levels (Admin only manages; others can view)
- **Sales Management:** Record sales with live total calculation, automatic stock deduction, printable bill/receipt, and void/restore (Admin/Cashier)
- **Customer Management:** Add / edit / delete customers and view full purchase history
- **Reports:** Daily sales, monthly sales (with daily breakdown), product stock report, customer purchase report — all printable (Admin/Manager)

## Setup Instructions

### 1. Requirements
- PHP >= 8.2 with the `pdo_mysql` extension
- Composer
- MySQL Server (or MariaDB)

### 2. Install dependencies
```bash
composer install
```

### 3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your MySQL credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clothing_erp
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Create the database
Create a MySQL database named `clothing_erp` (or whatever you set in `.env`):
```sql
xCREATE DATABASE clothing_erp;
```n 

### 5. Run migrations and seed demo data
```bash
php artisan migrate --seed
```

This creates the `users`, `products`, `customers`, and `sales` tables, and
seeds three demo accounts plus sample products/customers.

### 6. Serve the application
```bash
php artisan serve
```

Visit **http://localhost:8000** in your browser.

## Demo Accounts (created by the seeder)

| Role     | Email                       | Password |
|----------|-----------------------------|----------|
| Admin    | admin@clothingerp.test      |Admin@1234|
| Cashier  | cashier@clothingerp.test    |cashier@1234|
| Manager  | manager@clothingerp.test    |manager@1234|

## Role Permissions

| Module              | Admin | Cashier | Manager |
|---------------------|:-----:|:-------:|:-------:|
| View Products       |  ✅   |   ✅    |   ✅    |
| Add/Edit/Delete Products | ✅ |  ❌    |   ❌    |
| View Customers      |  ✅   |   ✅    |   ✅    |
| Add/Edit/Delete Customers | ✅ | ❌    |   ❌    |
| Record Sales        |  ✅   |   ✅    |   ❌    |
| Void Sales          |  ✅   |   ❌    |   ❌    |
| View Sales          |  ✅   |   ✅    |   ✅    |
| Reports             |  ✅   |   ❌    |   ✅    |

## Project Structure
```
app/
  Http/Controllers/    Product, Customer, Sale, Report, Dashboard, Auth controllers
  Http/Middleware/      RoleMiddleware.php — restricts routes by role
  Models/               User, Product, Customer, Sale (Eloquent models)
database/
  migrations/           Schema for users, products, customers, sales
  seeders/               Demo users + sample data
resources/views/
  layouts/               app.blade.php (authenticated layout), guest.blade.php (login)
  auth/                  login.blade.php
  dashboard/             index.blade.php
  products/              index, create, edit, _form
  customers/             index, create, edit, show, _form
  sales/                 index, create, show (printable bill)
  reports/               daily, monthly, stock, customer-purchases
routes/web.php           All application routes with role middleware
public/css/app.css       Custom styling on top of Bootstrap
public/js/app.js         Auto-dismiss alerts
```

## Notes
- Stock is automatically decremented when a sale is recorded (wrapped in a
  DB transaction with row locking to prevent overselling), and restored if
  a sale is voided.
- Sale totals are calculated server-side at save time (price × quantity at
  time of sale), with a live JS preview on the "Record Sale" form.
- Bills and reports include a browser print button (`window.print()`) with
  print-specific CSS to hide navigation chrome.
