# FloraWeb — Flower E-Commerce Course Project

A collaborative PHP/MySQL course project for browsing flowers, account registration and login, a session cart, cash-on-delivery orders, and an administrator dashboard. The interface uses HTML, CSS, and JavaScript. Payment is **cash on delivery**; there is no online payment processor. The coupon screen stores promotional codes for administrators, but checkout does not redeem them.

## Requirements

- PHP 8.2+ with `mysqli` and `mysqlnd`
- MySQL 8 or MariaDB 10.4+ (the supplied export came from MariaDB 10.4)
- XAMPP is one convenient local option

## Local setup with XAMPP

1. Copy this folder to `htdocs/floraweb` and start Apache and MySQL.
2. Open phpMyAdmin, select the **SQL** tab, and import `database.sql`. It creates `floraweb_db`, its source tables and 25 sample products, plus the coupon table used by the admin interface. Import into a fresh local installation to avoid duplicate-table errors.
3. If your MySQL username/password differs from XAMPP's local `root` / blank password, set `FLORAWEB_DB_HOST`, `FLORAWEB_DB_USER`, `FLORAWEB_DB_PASSWORD`, and optionally `FLORAWEB_DB_NAME` as environment variables for PHP. The defaults are in `includes/db_connect.php`.
4. Visit `http://localhost/floraweb/`. Register a customer account and test login, cart, and checkout.
5. To test the admin panel locally, change the registered account's role in phpMyAdmin: `UPDATE users SET role = 'admin' WHERE email = 'your-own-email@example.com';` Log out and log back in, then visit `http://localhost/floraweb/admin/`.

The original database export contains no user accounts or passwords. Do not publish personal data or live credentials in a public repository. This package includes no customer records.

## Repository layout

- `database.sql`: original database structure and sample data, plus the coupon table needed by the PHP admin screen
- `index.php`, `products.php`, `cart.php`, `checkout.php`: storefront and order flow
- `login.php`, `register.php`, `logout.php`: accounts
- `admin/`: protected product, order, user and coupon screens
- `assets/`: styles, JavaScript, images and local video

## Team contribution

This was a group project. In a CV or interview, describe **your own** work separately from the team's complete application. The JavaScript interface work has been identified as one contribution; revise `CV_PROJECT_ENTRY.md` after confirming the exact features you personally implemented and add teammates' credits if they agree.

## Known scope and limits

- The coupon management screen does not apply discounts to orders.
- The contact form displays a confirmation but does not send or store messages.
- Admin accounts are promoted manually for local demonstration.
- Product images are selected by a file-name convention. New products without a matching image use the bundled logo.
- This repository is a course demonstration. Before public deployment, add CSRF protection to state-changing forms, stricter validation and output escaping throughout admin screens, and configure a real server environment.

## Verification

Verified with PHP 8.3 and MariaDB 10.11 in a temporary local test environment. All PHP files passed syntax checks, JavaScript passed Node.js syntax checks, and `database.sql` imported successfully. HTTP smoke tests passed for the public pages, registration, login, adding a product to the cart, checkout, database order creation, logout, administrator login, and all five administrator pages. An unauthenticated request to the admin dashboard redirected to login. The HTTP responses and PHP log contained no PHP warnings or fatal errors. These are development smoke tests; they do not establish production readiness or complete browser/device coverage.
