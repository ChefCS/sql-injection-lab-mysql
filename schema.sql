CREATE DATABASE IF NOT EXISTS vulnerable_db;
USE vulnerable_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL  -- Insecure: stored in plain text for vuln purposes
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT
);

-- Insert sample data (only if not already present – safe to run multiple times)
INSERT IGNORE INTO users (username, password) VALUES ('admin', 'admin123'), ('user', 'pass123');
INSERT IGNORE INTO products (name, price, description) VALUES 
('Laptop', 999.99, 'High-end gaming laptop'),
('Phone', 499.99, 'Latest smartphone'),
('Headphones', 99.99, 'Noise-cancelling headphones');