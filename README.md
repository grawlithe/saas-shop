# SaaS Shop

A simple e-commerce application built with Laravel 12, allowing customers to browse and purchase products, and administrators to manage the catalog and view orders.

## Features

### Customer Interface
- **Browse Products**: View a grid of available products.
- **Product Details**: View detailed information about a product.
- **Purchase**: Authenticated users can purchase products (creates an order).

### Admin Panel
- **Product Management**: Create, Read, Update, and Delete products.
- **Order Management**: View a list of all customer orders with status and totals.
- **Authentication**: Secure login and registration for users and admins.

## Tech Stack

- **Framework**: [Laravel 12](https://laravel.com)
- **Styling**: [Tailwind CSS v4](https://tailwindcss.com)
- **Bundling**: [Vite](https://vitejs.dev)
- **Testing**: [Pest](https://pestphp.com)
- **Authentication**: [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)

## Setup Instructions

1.  **Clone the repository**
    ```bash
    git clone <repository-url>
    cd saas-shop
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    Configure your database settings in `.env`.

4.  **Database Migration & Seeding**
    ```bash
    php artisan migrate
    ```

5.  **Run the Application**
    ```bash
    npm run dev
    # In a separate terminal
    php artisan serve
    ```

## Testing

This project uses Pest for testing. To run the test suite:

```bash
php artisan test
```
