
# Binar Technical Test - Backend (User Management API)

This repository contains the solution for the Binar Technical Test (Backend). It is a RESTful API built with **Laravel 12**, focusing on clean architecture, scalability, and secure role-based access control.

## 🚀 Key Features

- **Role Management**: Implemented using **PHP 8.1+ Backed Enums** for strict typing and better code maintenance.
- **Dynamic Permission (`can_edit`)**: Complex logic determines edit permissions based on the requester's role (Admin, Manager, User).
- **Service-Repository Pattern**: Decoupled business logic and database queries to ensure the Controller remains thin and testable.
- **Data Transfer Objects (DTOs)**: Used for strictly typed filtering parameters, avoiding loose array passing.
- **Automated Testing**: Comprehensive Feature Tests covering happy paths, edge cases, and validation rules.
- **Secure Validation**: Custom Form Requests to prevent invalid sorting columns and ensure data integrity.

## 🛠 Tech Stack

- **Framework**: Laravel 12
- **Language**: PHP 8.3
- **Database**: SQLite (Default for Testing) / MySQL Compatible
- **Tools**: Laravel Sanctum (Auth), PHPUnit (Testing)

---

## ⚙️ Installation & Setup

1. **Clone the repository**
```bash
git clone <your-repo-url>
cd <folder-name>

```


2. **Install Dependencies**
```bash
composer install

```


3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate

```


4. **Database Migration & Seeding**
This command will create the database structure and populate it with dummy data (Admin, Manager, and Users) required for testing the logic.
```bash
# Ensure your database file exists (e.g., database/database.sqlite)
php artisan migrate:fresh --seed

```


5. **Run the Server**
```bash
php artisan serve

```



---

## 🧪 How to Test (Reviewer Guide)

### Option A: Automated Testing (Recommended)

Run the complete test suite to verify all logic, including role permissions, email events, and validation rules.

```bash
php artisan test

```

### Option B: Manual Testing (Postman/Insomnia)

Since the requirement focuses on the `can_edit` logic which requires Authentication context, but there is no specific requirement for a full Login endpoint, I provided a **Helper Route** to easily generate tokens for testing in the local environment.

#### 1. Generate Token (Dev Only)

**POST** `/api/dev/login`

```json
{
    "email": "admin@example.com"
}

```

*Available Emails from Seeder:* - `admin@example.com` (Role: Admin)

* `manager@example.com` (Role: Manager)
* or any user email from database.

#### 2. Create User (Public Endpoint)

**POST** `/api/users`

```json
{
    "name": "New Candidate",
    "email": "candidate@binar.test",
    "password": "password123"
}

```

#### 3. Get Users (Test `can_edit` logic)

**GET** `/api/users?search=Candidate&sortBy=name&sortDirection=asc`

* **Headers**: `Authorization: Bearer <YOUR_TOKEN>`
* **Check**: Look at the `can_edit` field in the response. It will change based on the Token used (Admin vs Manager vs User).

---

## 📂 Project Structure Highlights

I implemented a modular structure to demonstrate scalability and separation of concerns:

* **`app/DTOs`**: Type-safe data transfer (e.g., `UserFilterDTO`).
* **`app/Services`**: Business logic layer (e.g., `UserService`).
* **`app/Repositories`**: Database interaction layer (e.g., `UserRepository`).
* **`app/Interfaces`**: Contracts for Repositories to support Dependency Injection.
* **`app/Http/Requests`**: Validation layer (e.g., `IndexUserRequest`).
* **`app/Http/Resources`**: API Response transformation and permission logic.
* **`app/Enums`**: Role definitions (`RoleEnum`).

---

## 🛡️ Security Measures

* **Strict Validation**: Prevents SQL Injection via `sortBy` parameter whitelist.
* **Force JSON**: Middleware to ensure API always returns JSON responses.
* **Environment Protection**: Dev routes are strictly limited to `local` environment.

```

Silakan langsung dipasang, Mas! Ini udah lengkap banget.
Kalau udah `git push`, kasih tau ya, biar kita rayakan! 🥳🚀

```