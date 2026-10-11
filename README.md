# LaravelRental — Equipment Rental Management System

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2F8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)

An enterprise-grade, full-stack Equipment Rental Management application engineered with Laravel 10, Tailwind CSS, MySQL, and Docker containerization. Designed to solve complex inventory workflows, track asset availability across distinct timeframes, and enforce granular Role-Based Access Control (RBAC).

---

## Key Features & Business Logic

- **Authentication & Security:** Built-in authentication workflows powered by Laravel Breeze/Jetstream, supporting session management, password resets, and middleware protection against unauthorized resource access.
- **Granular Role-Based Access Control (RBAC):** Dynamic role and permission assignments via spatie/laravel-permission, isolating administrative capabilities from regular customer accounts.
- **Inventory & Category Catalog:** Complete management for equipment listings, categorization, search indexing, and real-time availability tracking.
- **Rental Lifecycle Management:** End-to-end booking process enabling users to request equipment, view rental history, manage schedule overlap, and process cancellations.
- **Admin Control Center:** Centralized management views for inspecting user rosters, adjusting active permissions, modifying equipment assets, and auditing system-wide rental requests.

---

## Tech Stack & Dependencies

### Core Framework & Backend
- **Framework:** Laravel 10.x running on PHP 8.2+
- **Database ORM:** Eloquent ORM with MySQL relational schema
- **Role Management:** spatie/laravel-permission
- **Development Tools:** Laravel Telescope & Laravel Debugbar for runtime query auditing and profiling

### Frontend & Build Pipeline
- **Styling:** Tailwind CSS with @tailwindcss/forms plugin
- **Asset Bundling:** Vite with Hot Module Replacement (HMR)
- **UI Components:** Blade Templates with Alpine.js / Vue 3 components

---

## Database Architecture

The database schema utilizes strict relational constraints and foreign key indexing to guarantee data integrity across user bookings and equipment availability.

\\\
       +-------------------+             +-------------------+
       |       Users       |             |     Categories    |
       +-------------------+             +-------------------+
       | id (PK)           |             | id (PK)           |
       | name              |             | name              |
       | email             |             | slug              |
       | role_id (FK)      |             +---------+---------+
       +---------+---------+                       |
                 | 1                               | 1
                 |                                 |
                 | N                               | N
       +---------v---------+             +---------v---------+
       |      Rentals      |             |       Items       |
       +-------------------+             +-------------------+
       | id (PK)           |             | id (PK)           |
       | user_id (FK)      |             | category_id (FK)  |
       | item_id (FK)      |<------------| name              |
       | rental_date       | N         1 | price_per_day     |
       | return_date       |             | status            |
       | status            |             +-------------------+
       +-------------------+
\\\

### Entity Relationships
- **User -> Rental (1:N):** A single user can hold multiple rental transactions over time.
- **Category -> Item (1:N):** Equipment items belong to specific categories for structured querying.
- **Item -> Rental (1:N):** Equipment items can have sequential rental records tracking historical use.
- **Role <-> Permission (M:N):** Roles map to fine-grained access permissions through pivot tables.

---

## Local Development Setup

Follow these steps to run the application locally on your native PHP environment:

### Prerequisites
- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 18.x & NPM
- MySQL >= 5.7 or 8.0

### Setup Steps

1. **Clone the Repository:**
   \\\ash
   git clone https://github.com/polekv/LaravelRental.git
   cd LaravelRental
   \\\

2. **Install PHP Dependencies:**
   \\\ash
   composer install
   \\\

3. **Install Frontend Dependencies:**
   \\\ash
   npm install
   \\\

4. **Environment Setup:**
   \\\ash
   cp .env.example .env
   php artisan key:generate
   \\\

5. **Configure Database Settings:**
   Update your .env file with your local MySQL credentials:
   \\\env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=equipment_rental
   DB_USERNAME=root
   DB_PASSWORD=
   \\\

6. **Execute Database Migrations & Seeders:**
   \\\ash
   php artisan migrate --seed
   \\\

7. **Compile Frontend Assets:**
   \\\ash
   npm run dev
   \\\

8. **Start Application Server:**
   \\\ash
   php artisan serve
   \\\
   Navigate to http://127.0.0.1:8000 in your web browser.

---

## Docker Container Setup

This project includes a fully containerized runtime environment configured with Docker and Docker Compose for consistent multi-platform deployments.

### Quick Start with Docker

1. **Build and Launch Containers:**
   \\\ash
   docker-compose up -d --build
   \\\

2. **Initialize Containerized Application:**
   \\\ash
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --seed
   \\\

3. **Access Services:**
   - **Web Application:** http://localhost:8000
   - **Database Host:** Internal Docker container equipment_rental_db:3306

---

## Testing & Quality Assurance

Run the automated test suite using PHPUnit to verify authentication flows, controller responses, and database transactions:

\\\ash
php artisan test
\\\

---

## License

This project is open-source software licensed under the [MIT License](LICENSE).
