DROP DATABASE IF EXISTS hospital_db;
CREATE DATABASE hospital_db;
USE hospital_db;

CREATE TABLE users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    full_name     VARCHAR(100) NOT NULL,
    email         VARCHAR(100) NOT NULL UNIQUE,
    password      VARCHAR(255) NOT NULL,
    phone         VARCHAR(20),
    gender        ENUM('male', 'female'),
    date_of_birth DATE,
    role          ENUM('admin', 'doctor', 'patient') NOT NULL DEFAULT 'patient',
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE departments (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

CREATE TABLE doctors (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    user_id        INT NOT NULL UNIQUE,
    department_id  INT,
    specialization VARCHAR(100),
    FOREIGN KEY (user_id)       REFERENCES users(id)       ON DELETE CASCADE,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
);

CREATE TABLE appointments (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    patient_id       INT NOT NULL,
    doctor_id        INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    reason           VARCHAR(255) NOT NULL,
    status           ENUM('pending', 'confirmed', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    doctor_notes     TEXT,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id)   ON DELETE CASCADE,
    FOREIGN KEY (doctor_id)  REFERENCES doctors(id) ON DELETE CASCADE
);


INSERT INTO departments (id, name, description) VALUES
(1, 'General Medicine', 'Check-ups and common illnesses.'),
(2, 'Cardiology',       'Heart and blood vessel care.'),
(3, 'Pediatrics',       'Medical care for children.'),
(4, 'Orthopedics',      'Bones, joints and muscles.');

INSERT INTO users (id, full_name, email, password, phone, gender, date_of_birth, role) VALUES
(1, 'System Admin',    'admin@hospital.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0500000001', 'male',   NULL,         'admin'),
(2, 'Dr. Sara Ahmed',  'sara@hospital.com',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0500000002', 'female', NULL,         'doctor'),
(3, 'Dr. Omar Khalid', 'omar@hospital.com',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0500000003', 'male',   NULL,         'doctor'),
(4, 'Ali Hassan',      'patient@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0500000004', 'male',   '1998-04-12', 'patient');


INSERT INTO doctors (id, user_id, department_id, specialization) VALUES
(1, 2, 1, 'General Practitioner'),
(2, 3, 2, 'Cardiologist');


INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, reason) VALUES
(4, 1, '2026-12-01', '10:00:00', 'Routine check-up'),
(4, 2, '2026-12-02', '11:00:00', 'Heart palpitations');

