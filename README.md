# SaaS Shop

A full-featured e-commerce application built with Laravel 12, featuring an admin panel for product and order management, a customer-facing shop interface, and Stripe payment integration.

## Features

### Customer Interface
- **Browse Products**: View all available products in a responsive grid layout
- **Product Details**: View detailed information about individual products with pricing
- **Secure Checkout**: Purchase products via Stripe Checkout (requires authentication)
- **Order Confirmation**: Receive confirmation after successful purchase

### Admin Panel
- **Dashboard**: Centralized admin dashboard with navigation to all admin features
- **Product Management**: 
  - Create new products with name and price
  - Edit existing product details
  - Delete products from the catalog
  - View all products in a paginated table
- **Order Management**: 
  - View all customer orders
  - See order details: ID, customer, status, total amount, items count, date
  - Track order statuses (pending, paid, etc.)
- **Responsive Design**: Admin interface works seamlessly on desktop and mobile

### Payment Integration
- **Stripe Checkout**: Secure payment processing via Laravel Cashier
- **Payment Flow**:
  - User clicks "Buy Now" → Redirected to Stripe hosted checkout
  - Payment success → Order created with "paid" status
  - Payment cancelled → User returned to shop with no order created
- **Test Mode Support**: Easily test with Stripe test API keys

### Authentication & Security
- **Laravel Breeze**: Built-in authentication scaffolding
- **Protected Routes**: Admin and checkout routes require authentication
- **Session Management**: Secure user sessions with password hashing

## Tech Stack

- **Framework**: [Laravel 12](https://laravel.com) - Latest Laravel version with streamlined structure
- **Payment Processing**: [Laravel Cashier](https://laravel.com/docs/billing) + [Stripe](https://stripe.com)
- **Authentication**: [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze) (Blade + Tailwind)
- **Styling**: [Tailwind CSS v4](https://tailwindcss.com)
- **Build Tool**: [Vite](https://vitejs.dev)
- **Testing**: [Pest](https://pestphp.com) - Modern PHP testing framework
- **PHP**: 8.4.14
- **Database**: MySQL/PostgreSQL (configurable)

## Setup Instructions

### 1. Clone the Repository
```bash
git clone <repository-url>
cd saas-shop
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Configure your `.env` file with:
- **Database credentials**
- **Stripe API keys** (for payment functionality):
  ```
  STRIPE_KEY=pk_test_your_stripe_publishable_key
  STRIPE_SECRET=sk_test_your_stripe_secret_key
  ```

> **Note**: Get your Stripe test keys from [Stripe Dashboard](https://dashboard.stripe.com/test/apikeys)

### 4. Database Setup
```bash
php artisan migrate
```

### 5. Run the Application

**Option 1: Using Laravel Herd** (Recommended for local development)
- Application automatically available at `http://saas-shop.test`
- Run: `npm run dev` for asset compilation

**Option 2: Using Artisan Serve**
```bash
npm run dev
# In a separate terminal
php artisan serve
```
- Application available at `http://localhost:8000`

## Testing

This project has comprehensive test coverage using Pest:

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --filter=ShopTest
php artisan test --filter=Admin/ProductTest
```

**Test Coverage:**
- ✓ Admin product CRUD operations
- ✓ Admin order listing
- ✓ Shop product browsing
- ✓ Checkout success/cancel flows
- ✓ Authentication and authorization

## Application Structure

### Routes
- `/` - Shop homepage (public)
- `/products/{id}` - Product details (public)
- `/login` - User login
- `/register` - User registration
- `/admin/products` - Product management (authenticated)
- `/admin/orders` - Order management (authenticated)
- `/checkout/success` - Payment success handler
- `/checkout/cancel` - Payment cancellation handler

### Key Files
- **Controllers**: `app/Http/Controllers/`
  - `ShopController.php` - Customer shop and checkout
  - `Admin/ProductController.php` - Product management
  - `Admin/OrderController.php` - Order management
- **Models**: `app/Models/`
  - `Product.php` - Product model
  - `Order.php` - Order model with product relationships
  - `User.php` - User model with Billable trait
- **Views**: `resources/views/`
  - `shop/` - Customer-facing views
  - `admin/` - Admin panel views
- **Tests**: `tests/Feature/`
  - `ShopTest.php`
  - `Admin/ProductTest.php`
  - `Admin/OrderTest.php`

## Usage Guide

### For Customers
1. Visit the shop homepage to browse products
2. Click "View Details" to see product information
3. Click "Buy Now" (login required)
4. Complete payment via Stripe Checkout
5. Receive order confirmation

### For Administrators
1. Login with admin credentials
2. Navigate to "Products" to manage the catalog
3. Navigate to "Orders" to view customer orders
4. Create/edit/delete products as needed

## Development Notes

- **Code Style**: Automatically formatted with Laravel Pint
- **Laravel Conventions**: Follows Laravel 12 best practices
- **Database**: Uses Eloquent ORM with proper relationships
- **Migrations**: All database changes tracked in migrations
- **Factories**: Product factory included for testing/seeding

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
