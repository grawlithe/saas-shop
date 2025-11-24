# SaaS Shop

A full-featured e-commerce application built with Laravel 12, featuring an admin panel for product and order management, a customer-facing shop interface with a shopping cart, and Stripe payment integration.

## Features

### Account Types
- **Customer**: Can browse products, manage cart, and place orders.
- **Administrator**: Can manage products, users, and view all orders. Role-based access control ensures security.

### Customer Interface
- **Browse Products**: View all available products in a responsive grid layout
- **Shopping Cart**:
  - Add multiple products to cart
  - Update quantities
  - Remove items
  - View total cost
- **Secure Checkout**: Purchase multiple items via Stripe Checkout (requires authentication)
- **Order Confirmation**: Receive confirmation after successful purchase

### Admin Panel
- **Dashboard**: Centralized admin dashboard with navigation to all admin features
- **User Management**:
  - View all admin users
  - Create new admin users (Invite-only system)
- **Product Management**: 
  - Create new products with name and price (Input in dollars, stored as cents)
  - Edit existing product details
  - Delete products from the catalog
  - View all products in a paginated table with formatted prices (e.g., $15.00)
- **Order Management**: 
  - View all customer orders
  - See order details: ID, customer, status, total amount, items count, date
  - Track order statuses (pending, paid, etc.)
- **Responsive Design**: Admin interface works seamlessly on desktop and mobile

### Payment Integration
- **Stripe Checkout**: Secure payment processing via Laravel Cashier
- **Payment Flow**:
  - User clicks "Checkout" from Cart → Redirected to Stripe hosted checkout
  - Payment success → Order created with "paid" status and cart cleared
  - Payment cancelled → User returned to shop with no order created
- **Test Mode Support**: Easily test with Stripe test API keys

### Authentication & Security
- **Laravel Breeze**: Built-in authentication scaffolding
- **Protected Routes**: Admin, cart, and checkout routes require authentication
- **Role-Based Access**: Middleware ensures only admins access admin routes
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
php artisan db:seed --class=AdminUserSeeder # Create default admin user
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
php artisan test --filter=CartTest
php artisan test --filter=AdminTest
```

**Test Coverage:**
- ✓ Admin product CRUD operations
- ✓ Admin user management
- ✓ Shopping cart functionality (Add, Update, Remove)
- ✓ Checkout success/cancel flows
- ✓ Authentication and authorization

## Application Structure

### Routes
- `/` - Shop homepage (public)
- `/cart` - Shopping cart (authenticated)
- `/login` - User login
- `/register` - User registration
- `/admin/products` - Product management (admin only)
- `/admin/users` - Admin user management (admin only)
- `/admin/orders` - Order management (admin only)
- `/checkout/success` - Payment success handler
- `/checkout/cancel` - Payment cancellation handler

### Key Files
- **Controllers**: `app/Http/Controllers/`
  - `ShopController.php` - Customer shop and checkout
  - `CartController.php` - Shopping cart management
  - `Admin/ProductController.php` - Product management
  - `Admin/UserController.php` - Admin user management
  - `Admin/OrderController.php` - Order management
- **Models**: `app/Models/`
  - `Product.php` - Product model
  - `Cart.php` & `CartItem.php` - Shopping cart models
  - `Order.php` - Order model with product relationships
  - `User.php` - User model with Billable trait and admin check
- **Views**: `resources/views/`
  - `shop/` - Customer-facing views
  - `cart/` - Shopping cart views
  - `admin/` - Admin panel views
- **Tests**: `tests/Feature/`
  - `CartTest.php`
  - `AdminTest.php`
  - `ShopTest.php`

## Usage Guide

### For Customers
1. Visit the shop homepage to browse products
2. Click "Add to Cart" to add items
3. Go to "Cart" to review items and update quantities
4. Click "Checkout" (login required)
5. Complete payment via Stripe Checkout
6. Receive order confirmation

### For Administrators
1. Login with admin credentials
2. Navigate to "Products" to manage the catalog (Prices in $)
3. Navigate to "Users" to manage admin access
4. Navigate to "Orders" to view customer orders

## Development Notes

- **Code Style**: Automatically formatted with Laravel Pint
- **Laravel Conventions**: Follows Laravel 12 best practices
- **Database**: Uses Eloquent ORM with proper relationships
- **Migrations**: All database changes tracked in migrations
- **Factories**: Product and User factories included for testing/seeding

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
