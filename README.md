# MyShop E-Commerce Platform by Kevin

## Features

*   **Product Catalog:** Browse and search for products. View detailed product pages with descriptions, specifications, and images.
*   **Shopping Cart:** Add items to the cart, update quantities, or remove items. The cart count in the navigation bar updates dynamically.
*   **Instant Checkout (Buy Now):** Skip the cart and proceed directly to checkout for a single item.
*   **Order Management:** Users can view their order history and update the status of their orders (e.g., cancel).
*   **User Authentication:** Secure user registration and login powered by Laravel Fortify.
    *   **Google Social Login:** Register or log in using a Google account.
*   **Responsive UI:** A clean interface built with Tailwind CSS and shadcn-vue, designed to work on both desktop and mobile devices.
*   **Appearance Customization:** Switch between light, dark, and system themes.

## Tech Stack

*   **Backend:** Laravel 12, PHP 8.2
*   **Frontend:** Vue.js 3, TypeScript, Inertia.js
*   **Database:**  MySQL
*   **Styling:** Tailwind CSS
*   **Authentication:** Laravel Fortify, Laravel Socialite
*   **Bundler:** Vite
*   **Tooling:** Composer, npm, Prettier

## Getting Started

### Prerequisites

*   PHP >= 8.2
*   Composer
*   Node.js & npm
*   A configured database (SQLite is the default and requires no extra setup).

### Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/mkevin1491/Software-Engineer-PHP-Assessment_KevinLogChongHoe.git
    cd Software-Engineer-PHP-Assessment_KevinLogChongHoe
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Set up your environment file:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure your `.env` file:**
    The application is configured to use SQLite by default. If you wish to use MySQL or another database, update the `DB_*` variables in your `.env` file. To enable Google login, add your credentials:
    ```env
    GOOGLE_CLIENT_ID=your-google-client-id
    GOOGLE_CLIENT_SECRET=your-google-client-secret
    GOOGLE_REDIRECT=http://localhost:8000/auth/google/callback
    ```

6.  **Run database migrations:**
    ```bash
    php artisan migrate
    ```

7.  **Seed the database with products and a test user:**
    ```bash
    php artisan db:seed --class=ProductSeeder
    php artisan db:seed --class=DatabaseSeeder 
    ```
    This will create sample products and a test user with credentials:
    *   **Email:** `test@example.com`
    *   **Password:** `password`

8.  **Install frontend dependencies:**
    ```bash
    npm install
    ```

### Running the Application

This project includes a convenient script to start all necessary services concurrently.

```bash
composer run dev
```

This command will:
1.  Start the Laravel development server (`php artisan serve`).
2.  Start the queue worker (`php artisan queue:listen`).
3.  Start the Vite development server for hot module replacement (`npm run dev`).

You can now access the application at `http://localhost:8000`.

## Testing

The application comes with a suite of feature and unit tests. To run the tests, execute the following command:

```bash
composer test
```

This will run the full PHPUnit test suite using an in-memory SQLite database.

## Code Style & Linting

This project uses linters to maintain code quality.

*   **PHP (Laravel Pint):** To format your PHP code, run:
    ```bash
    ./vendor/bin/pint
    ```

*   **TypeScript & Vue (ESLint/Prettier):** To format your frontend code, run:
    ```bash
    npm run lint
    npm run format
