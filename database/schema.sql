CREATE DATABASE IF NOT EXISTS hospital_db;
USE hospital_db;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(150) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    status ENUM('active', 'disabled') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_roles (
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    age INT NOT NULL,
    sex VARCHAR(20) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    address VARCHAR(255),
    history TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE opd_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    commission_type ENUM('percentage', 'fixed') NOT NULL,
    commission_value DECIMAL(10,2) NOT NULL
);

CREATE TABLE pathology_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(100) NOT NULL,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    commission_type ENUM('percentage', 'fixed') NOT NULL,
    commission_value DECIMAL(10,2) NOT NULL
);

CREATE TABLE bills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id VARCHAR(20) NOT NULL UNIQUE,
    patient_id INT NOT NULL,
    bill_type ENUM('OPD', 'Pathology') NOT NULL,
    refer_doctor VARCHAR(150),
    consultant_doctor VARCHAR(150),
    total_amount DECIMAL(10,2) NOT NULL,
    paid_amount DECIMAL(10,2) NOT NULL,
    due_amount DECIMAL(10,2) NOT NULL,
    discount DECIMAL(10,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id)
);

CREATE TABLE bill_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bill_id INT NOT NULL,
    item_type VARCHAR(50) NOT NULL,
    item_name VARCHAR(150) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (bill_id) REFERENCES bills(id) ON DELETE CASCADE
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bill_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bill_id) REFERENCES bills(id) ON DELETE CASCADE
);

CREATE TABLE commissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_name VARCHAR(150) NOT NULL,
    role VARCHAR(50) NOT NULL,
    bill_id INT NOT NULL,
    commission_type ENUM('percentage', 'fixed') NOT NULL,
    commission_value DECIMAL(10,2) NOT NULL,
    commission_amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bill_id) REFERENCES bills(id) ON DELETE CASCADE
);

CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    specialization VARCHAR(150),
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active'
);

CREATE TABLE staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    role VARCHAR(100) NOT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active'
);

INSERT INTO roles (name) VALUES
('Super Admin'),
('Admin'),
('Receptionist'),
('Doctor'),
('Nurse'),
('Pathologist'),
('Pharmacist');

INSERT INTO permissions (name) VALUES
('view_dashboard'),
('manage_users'),
('manage_patients'),
('manage_opd'),
('manage_pathology'),
('manage_billing'),
('view_reports');

INSERT INTO role_permissions (role_id, permission_id) VALUES
(1, 1),(1, 2),(1, 3),(1, 4),(1, 5),(1, 6),(1, 7),
(2, 1),(2, 3),(2, 4),(2, 5),(2, 6),(2, 7),
(3, 1),(3, 3),(3, 6),
(4, 1),(4, 6),
(5, 1),(5, 3),
(6, 1),(6, 5),(6, 6),
(7, 1);

INSERT INTO users (username, full_name, password_hash, status) VALUES
('superadmin', 'Super Admin', '$2y$12$5YayCPNYGKkfG/GGE0xQDO5C5SoDnY24xBuMT5Yc2iS.wpDs2pxUy', 'active'),
('admin', 'Admin User', '$2y$12$5YayCPNYGKkfG/GGE0xQDO5C5SoDnY24xBuMT5Yc2iS.wpDs2pxUy', 'active'),
('reception', 'Receptionist User', '$2y$12$5YayCPNYGKkfG/GGE0xQDO5C5SoDnY24xBuMT5Yc2iS.wpDs2pxUy', 'active'),
('doctor', 'Doctor User', '$2y$12$5YayCPNYGKkfG/GGE0xQDO5C5SoDnY24xBuMT5Yc2iS.wpDs2pxUy', 'active'),
('nurse', 'Nurse User', '$2y$12$5YayCPNYGKkfG/GGE0xQDO5C5SoDnY24xBuMT5Yc2iS.wpDs2pxUy', 'active'),
('pathologist', 'Pathologist User', '$2y$12$5YayCPNYGKkfG/GGE0xQDO5C5SoDnY24xBuMT5Yc2iS.wpDs2pxUy', 'active'),
('pharmacist', 'Pharmacist User', '$2y$12$5YayCPNYGKkfG/GGE0xQDO5C5SoDnY24xBuMT5Yc2iS.wpDs2pxUy', 'active');

INSERT INTO user_roles (user_id, role_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

INSERT INTO patients (name, age, sex, mobile, address, history) VALUES
('Rahul Sharma', 32, 'Male', '9000000001', 'City Center', 'Routine checkup'),
('Maya Singh', 28, 'Female', '9000000002', 'Lake Road', 'Thyroid follow-up');

INSERT INTO opd_items (name, price, commission_type, commission_value) VALUES
('General Consultation', 500, 'percentage', 10),
('ECG', 800, 'fixed', 50);

INSERT INTO pathology_items (category, name, price, commission_type, commission_value) VALUES
('Blood', 'CBC', 400, 'percentage', 8),
('Imaging', 'X-Ray Chest', 700, 'fixed', 60);
