CREATE DATABASE IF NOT EXISTS touche_pas_au_klaxon
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE touche_pas_au_klaxon;

CREATE TABLE agencies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lastname VARCHAR(100) NOT NULL,
  firstname VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  phone VARCHAR(20) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('USER','ADMIN') NOT NULL DEFAULT 'USER'
);

CREATE TABLE trips (
  id INT AUTO_INCREMENT PRIMARY KEY,
  departure_at DATETIME NOT NULL,
  arrival_at DATETIME NOT NULL,
  total_seats INT NOT NULL,
  available_seats INT NOT NULL,
  author_id INT NOT NULL,
  contact_id INT NOT NULL,
  departure_agency_id INT NOT NULL,
  arrival_agency_id INT NOT NULL,

  CONSTRAINT fk_trip_author
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE RESTRICT,

  CONSTRAINT fk_trip_contact
  FOREIGN KEY (contact_id) REFERENCES users(id) ON DELETE RESTRICT,

  CONSTRAINT fk_trip_departure
  FOREIGN KEY (departure_agency_id) REFERENCES agencies(id) ON DELETE RESTRICT,

  CONSTRAINT fk_trip_arrival
  FOREIGN KEY (arrival_agency_id) REFERENCES agencies(id) ON DELETE RESTRICT,


  CONSTRAINT chk_dates CHECK (arrival_at > departure_at),
  CONSTRAINT chk_seats CHECK (available_seats <= total_seats),
  CONSTRAINT chk_positive_total_seats CHECK (total_seats > 0),
  CONSTRAINT chk_positive_available_seats CHECK (available_seats >= 0),
  CONSTRAINT chk_agencies CHECK (departure_agency_id <> arrival_agency_id)

  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP

);
