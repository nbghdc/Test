-- Hospital Management System Schema
CREATE DATABASE IF NOT EXISTS hms;
USE hms;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_roles (
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

CREATE TABLE user_permissions (
    user_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (user_id, permission_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    age INT NOT NULL,
    sex VARCHAR(20) NOT NULL,
    mobile VARCHAR(50) NOT NULL,
    address VARCHAR(255),
    history TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    specialization VARCHAR(150),
    commission_type ENUM('percentage', 'fixed') DEFAULT 'percentage',
    commission_value DECIMAL(10,2) DEFAULT 0
);

CREATE TABLE staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    role VARCHAR(100) NOT NULL,
    commission_type ENUM('percentage', 'fixed') DEFAULT 'percentage',
    commission_value DECIMAL(10,2) DEFAULT 0
);

CREATE TABLE opd_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    commission_type ENUM('percentage', 'fixed') DEFAULT 'percentage',
    commission_value DECIMAL(10,2) DEFAULT 0
);

CREATE TABLE pathology_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(150) NOT NULL,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    commission_type ENUM('percentage', 'fixed') DEFAULT 'percentage',
    commission_value DECIMAL(10,2) DEFAULT 0
);

CREATE TABLE bills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id VARCHAR(20) NOT NULL UNIQUE,
    patient_id INT NOT NULL,
    refer_doctor_id INT,
    consultant_doctor_id INT,
    bill_type ENUM('opd', 'pathology') NOT NULL,
    billing_date DATE NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    paid_amount DECIMAL(10,2) NOT NULL,
    due_amount DECIMAL(10,2) NOT NULL,
    discount DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (refer_doctor_id) REFERENCES doctors(id),
    FOREIGN KEY (consultant_doctor_id) REFERENCES doctors(id)
);

CREATE TABLE bill_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bill_id INT NOT NULL,
    item_type VARCHAR(50) NOT NULL,
    item_id INT NOT NULL,
    description VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (bill_id) REFERENCES bills(id) ON DELETE CASCADE
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bill_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date DATE NOT NULL,
    method VARCHAR(50) NOT NULL,
    FOREIGN KEY (bill_id) REFERENCES bills(id) ON DELETE CASCADE
);

CREATE TABLE commissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bill_id INT NOT NULL,
    staff_id INT,
    doctor_id INT,
    commission_type ENUM('percentage', 'fixed') NOT NULL,
    commission_value DECIMAL(10,2) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bill_id) REFERENCES bills(id) ON DELETE CASCADE
);

CREATE TABLE pathology_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bill_id INT NOT NULL,
    report_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bill_id) REFERENCES bills(id) ON DELETE CASCADE
);

INSERT INTO roles (name, slug) VALUES
('Super Admin', 'super_admin'),
('Admin', 'admin'),
('Receptionist', 'receptionist'),
('Doctor', 'doctor'),
('Nurse', 'nurse'),
('Pathologist', 'pathologist'),
('Pharmacist', 'pharmacist');

INSERT INTO permissions (name, slug) VALUES
('View Dashboard', 'dashboard.view'),
('View Patients', 'patients.view'),
('Create Patients', 'patients.create'),
('Create Billing', 'billing.create'),
('View Reports', 'reports.view');

INSERT INTO role_permissions (role_id, permission_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5),
(2, 1), (2, 2), (2, 3), (2, 4), (2, 5),
(3, 1), (3, 2), (3, 3), (3, 4),
(4, 1), (4, 2),
(5, 1), (5, 2),
(6, 1), (6, 2), (6, 4),
(7, 1), (7, 2);

INSERT INTO users (name, email, password, is_active) VALUES
('Super Admin', 'superadmin@hms.local', '$2y$12$i6y.R85oEEFuaLLPZVmbgu14ki.AxEpmUa4cWSC29db9Za4WYg8o6', 1),
('Admin', 'admin@hms.local', '$2y$12$i6y.R85oEEFuaLLPZVmbgu14ki.AxEpmUa4cWSC29db9Za4WYg8o6', 1),
('Receptionist', 'reception@hms.local', '$2y$12$i6y.R85oEEFuaLLPZVmbgu14ki.AxEpmUa4cWSC29db9Za4WYg8o6', 1),
('Doctor', 'doctor@hms.local', '$2y$12$i6y.R85oEEFuaLLPZVmbgu14ki.AxEpmUa4cWSC29db9Za4WYg8o6', 1),
('Nurse', 'nurse@hms.local', '$2y$12$i6y.R85oEEFuaLLPZVmbgu14ki.AxEpmUa4cWSC29db9Za4WYg8o6', 1),
('Pathologist', 'pathologist@hms.local', '$2y$12$i6y.R85oEEFuaLLPZVmbgu14ki.AxEpmUa4cWSC29db9Za4WYg8o6', 1),
('Pharmacist', 'pharmacist@hms.local', '$2y$12$i6y.R85oEEFuaLLPZVmbgu14ki.AxEpmUa4cWSC29db9Za4WYg8o6', 1);

INSERT INTO user_roles (user_id, role_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

INSERT INTO doctors (name, specialization, commission_type, commission_value) VALUES
('Dr. Rahman', 'Cardiology', 'percentage', 10.00),
('Dr. Khan', 'Orthopedics', 'fixed', 300.00);

INSERT INTO opd_items (name, price, commission_type, commission_value) VALUES
('Consultation', 500.00, 'percentage', 15.00),
('ECG', 800.00, 'fixed', 100.00);

INSERT INTO pathology_items (category, name, price, commission_type, commission_value) VALUES
('Hematology', 'CBC', 1200.00, 'percentage', 12.00),
('Biochemistry', 'LFT', 1800.00, 'percentage', 10.00);
