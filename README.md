<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# 💰 KharchaTrack

> Smart Personal Finance Tracker for Nepal

KharchaTrack is a full-stack web application built with Laravel 13 that helps users track their income and expenses, visualize spending patterns, and export financial data.

---

## 🖥️ Screenshots

> Add screenshots here after deployment

---

## ⚡ Tech Stack

| Technology        | Version |
| ----------------- | ------- |
| PHP               | 8.4     |
| Laravel           | 13.x    |
| MySQL             | 8.x     |
| Spatie Permission | 6.x     |
| Chart.js          | 4.x     |
| Tailwind CSS      | Via CDN |
| Font Awesome      | 6.x     |

---

## ✨ Features

### 👤 Authentication

- Custom login & register pages
- Password reset via email
- Auto assign roles on registration
- Auto create default categories on registration

### 📊 Dashboard

- Monthly income & expense summary cards
- Pie chart — spending by category
- Bar chart — income vs expense last 6 months
- Recent 5 transactions preview

### 💸 Transactions

- Add income & expense transactions
- Edit & delete transactions
- Filter by type, category, month
- Search by note
- Paginated transaction history
- Soft deletes for data safety

### 🗂️ Categories

- Default categories auto-created on register
- Create custom categories with color picker
- Income & expense category types
- Prevent deletion if category has transactions

### 📤 Export

- Export transactions as CSV
- Filter by date range, type, category
- Quick select — This Month, Last Month, Last 3 Months, This Year
- Excel compatible UTF-8 CSV

### 🛡️ Admin Panel

- Platform-wide stats
- View all users
- Toggle user roles (Admin/User)
- Activate/deactivate users
- Inactive users automatically logged out

---

## 🚀 Setup Instructions

### Requirements

- PHP 8.2+
- Composer 2.x
- Node.js 18+
- MySQL 8.x

### Installation

**1. Clone the repository:**

```bash
git clone https://github.com/YOUR_USERNAME/KharchaTrack.git
cd KharchaTrack
```

**2. Install dependencies:**

```bash
composer install
npm install
```

**3. Setup environment:**

```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure database in `.env`:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kharcha_track
DB_USERNAME=root
DB_PASSWORD=
```

**5. Run migrations:**

```bash
php artisan migrate
```

**6. Seed roles and admin user:**

```bash
php artisan db:seed --class=RoleSeeder
```

**7. Build assets:**

```bash
npm run build
```

**8. Start server:**

```bash
php artisan serve
```

Visit `http://localhost:8000` 🎉

---

## 👤 Demo Credentials

### Admin Account

```
Email:    admin@kharchatrack.com
Password: password123
```

### Regular User

```
Register a new account at /register
Default categories created automatically
```

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   └── Dashboard/
│   │       ├── Admin/
│   │       │   └── AdminController.php
│   │       ├── CategoryController.php
│   │       ├── DashboardController.php
│   │       ├── ExportController.php
│   │       └── TransactionController.php
│   ├── Middleware/
│   │   ├── AdminMiddleware.php
│   │   └── CheckUserActive.php
│   └── Requests/
│       ├── Category/
│       └── Transaction/
├── Models/
│   ├── Category.php
│   ├── Transaction.php
│   └── User.php
database/
├── migrations/
└── seeders/
    ├── CategorySeeder.php
    └── RoleSeeder.php
resources/
└── views/
    ├── auth/
    ├── dashboard/
    │   ├── layouts/
    │   │   ├── app.blade.php
    │   │   ├── head.blade.php
    │   │   ├── header.blade.php
    │   │   ├── sidebar.blade.php
    │   │   └── footer.blade.php
    │   └── pages/
    │       ├── admin/
    │       ├── categories/
    │       ├── dashboard/
    │       ├── export/
    │       └── transactions/
public/
└── assets/
    ├── css/
    │   └── style.css
    └── js/
        ├── script.js
        └── charts.js
```

---

## 🔐 Roles & Permissions

| Feature           | User | Admin |
| ----------------- | ---- | ----- |
| Dashboard         | ✅   | ✅    |
| Transactions      | ✅   | ✅    |
| Categories        | ✅   | ✅    |
| Export CSV        | ✅   | ✅    |
| Admin Panel       | ❌   | ✅    |
| Toggle User Roles | ❌   | ✅    |
| Deactivate Users  | ❌   | ✅    |

---

## 🌱 Future Improvements

- REST API with Laravel Sanctum for mobile app
- Budget limits with email notifications
- Recurring transactions
- Multi-currency support
- Dark mode

---

## 👨‍💻 Developer

**Shubham Karna**
Junior Laravel Developer at Kumo Labs, Kathmandu

- GitHub: [@mode-shubham-Dev](https://github.com/mode-shubham-Dev)

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).
