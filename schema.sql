CREATE DATABASE IF NOT EXISTS dolphin_crm;
USE dolphin_crm;

CREATE TABLE Users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO Users (firstname, lastname, password, email, role)
VALUES 
('Bob', 'Billings', 'password123', 'admin@project2.com', 'Admin'),
('Jan', 'Levinson', 'password123', 'jan.levinson@paper.co', 'Member'),
('David', 'Wallace', 'iamthecoolest', 'david.wallace@paper.co', 'Admin'),
('And', 'Benard', 'andbenardpass', 'and.benard@example.com', 'Member'),
('Daryl', 'Philbin', 'darylphilbin123', 'daryl.philbin@example.com', 'Member'),
('Erin', 'Hannon', 'erinhannonpass', 'erin.hannon@example.com', 'Member');


CREATE TABLE Contacts (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(255) NOT NULL,
    company VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    assigned_to INTEGER NOT NULL,
    created_by INTEGER NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL
);

CREATE TABLE Notes (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    contact_id INTEGER NOT NULL,
    comment TEXT NOT NULL,
    created_by INTEGER NOT NULL,
    created_at DATETIME NOT NULL
);
