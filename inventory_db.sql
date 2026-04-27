CREATE DATABASE IF NOT EXISTS inventory_db;
USE inventory_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    date_added DATE NOT NULL
);

-- Default login:
-- Username: admin
-- Password: admin123
-- The PHP login page automatically hashes this password after the first successful login.
INSERT INTO users (username, password)
SELECT 'admin', 'admin123'
WHERE NOT EXISTS (
    SELECT 1 FROM users WHERE username = 'admin'
);

INSERT INTO products (product_name, category, quantity, price, date_added)
SELECT 'Notebook', 'Office Supplies', 20, 2.50, CURDATE()
WHERE NOT EXISTS (
    SELECT 1 FROM products WHERE product_name = 'Notebook'
);

INSERT INTO products (product_name, category, quantity, price, date_added)
SELECT 'USB Cable', 'Electronics', 4, 6.99, CURDATE()
WHERE NOT EXISTS (
    SELECT 1 FROM products WHERE product_name = 'USB Cable'
);

INSERT INTO products (product_name, category, quantity, price, date_added)
SELECT 'Printer Ink', 'Office Supplies', 0, 19.99, CURDATE()
WHERE NOT EXISTS (
    SELECT 1 FROM products WHERE product_name = 'Printer Ink'
);
