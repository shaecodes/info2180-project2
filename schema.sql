CREATE DATABASE IF NOT EXISTS dolphin_crm;
USE dolphin_crm;

CREATE TABLE Users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Contacts (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(255) NOT NULL,
    company VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    assigned_to INT,
    created_by INT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (assigned_to) REFERENCES Users(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

CREATE TABLE Notes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    contact_id INTEGER NOT NULL,
    comment TEXT NOT NULL,
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES Users(id)
    created_at DATETIME NOT NULL,
);
