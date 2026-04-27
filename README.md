Inventory Management System
===========================

Simple inventory project built with pure PHP, HTML, basic CSS, and MySQL.

Project Structure
-----------------

```text
stockwise/
|-- about.php
|-- add_product.php
|-- config.php
|-- contact.php
|-- dashboard.php
|-- delete_product.php
|-- edit_product.php
|-- index.php
|-- inventory_db.sql
|-- login.php
|-- logout.php
|-- products.php
|-- README.md
|-- css/
|   `-- style.css
`-- includes/
    |-- auth.php
    |-- footer.php
    `-- header.php
```

Setup
-----

1. Copy this folder into your local PHP server directory, such as `htdocs` for XAMPP.
2. Open phpMyAdmin or MySQL.
3. Import `inventory_db.sql`.
4. Open `config.php` and update the database username/password if needed.
5. Visit the project in your browser, for example:

```text
http://localhost/stockwise/
```

Default Login
-------------

```text
Username: admin
Password: admin123
```

Pages Included
--------------

- Home: `index.php`
- About: `about.php`
- Login: `login.php`
- Dashboard: `dashboard.php`
- Products: `products.php`
- Add Product: `add_product.php`
- Edit Product: `edit_product.php`
- Contact: `contact.php`

Features
--------

- Login and logout using PHP sessions
- Protected dashboard and product pages
- Add, view, edit, delete, and search products
- Stock status display:
  - Out of Stock: quantity is `0`
  - Low Stock: quantity is `1` to `5`
  - In Stock: quantity is more than `5`
- Basic form validation
- MySQL database connection in `config.php`
