-- flight_booking_db.sql

-- Create the flight_booking_db database if it doesn't exist
CREATE DATABASE IF NOT EXISTS flight_booking_db;

-- Use the flight_booking_db database
USE flight_booking_db;

-- Create the Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    tel VARCHAR(20) NOT NULL UNIQUE,   
    account_balance DECIMAL(10, 2) DEFAULT 0.00,
    user_type ENUM('company', 'passenger') NOT NULL
);

-- Create the company table
CREATE TABLE company (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bio TEXT DEFAULT NULL, 
    address TEXT DEFAULT NULL,
    location VARCHAR(255) DEFAULT NULL,
    logo_img VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create the passenger table
CREATE TABLE passenger (
    id INT PRIMARY KEY AUTO_INCREMENT,
    passport_img VARCHAR(255) DEFAULT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create the Flights table
CREATE TABLE flights (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    itinerary TEXT NOT NULL,
    passengers_limit INT NOT NULL,
    passengers_registered INT DEFAULT 0,
    passengers_pending INT DEFAULT 0,
    fees DECIMAL(10, 2) NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    completed BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE
);

-- Create the passenger_flights table
CREATE TABLE passenger_flights (
    id INT PRIMARY KEY AUTO_INCREMENT,
    passenger_id INT NOT NULL,
    flight_id INT NOT NULL,
    status ENUM('Completed', 'Pending') NOT NULL,
    FOREIGN KEY (passenger_id) REFERENCES passenger(id) ON DELETE CASCADE,
    FOREIGN KEY (flight_id) REFERENCES flights(id) ON DELETE CASCADE
);

-- Create the messages table
CREATE TABLE messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message_text TEXT NOT NULL,
    timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);