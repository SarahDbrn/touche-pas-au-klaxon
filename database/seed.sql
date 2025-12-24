USE touche_pas_au_klaxon;

INSERT INTO agencies (name) VALUES
('Paris'),
('Lyon'),
('Marseille');

INSERT INTO users (lastname, firstname, email, phone, password, role) VALUES

('Admin', 'Super', 'admin@tpak.local', '0102030405', '$2y$10$XJer4k6VqicT0TdVPuU4vu9QDCzZnetvyTsHiZGY1MuXlgzxVI8BC', 'ADMIN'),
('Martin', 'Alex', 'alex@tpak.local', '0607080910', '$2y$10$XJer4k6VqicT0TdVPuU4vu9QDCzZnetvyTsHiZGY1MuXlgzxVI8BC', 'USER');

-- Trajets de test
-- Hypothèses seed existant :
-- agencies : Paris=1, Lyon=2, Marseille=3
-- users : admin=1, alex=2

INSERT INTO trips (
  departure_at, arrival_at,
  total_seats, available_seats,
  author_id, contact_id,
  departure_agency_id, arrival_agency_id
) VALUES
-- FUTUR + places dispo -> DOIT apparaître
(DATE_ADD(NOW(), INTERVAL 1 DAY),  DATE_ADD(NOW(), INTERVAL 1 DAY) + INTERVAL 2 HOUR, 4, 3, 2, 2, 1, 2),

-- FUTUR + places dispo -> DOIT apparaître
(DATE_ADD(NOW(), INTERVAL 3 DAY),  DATE_ADD(NOW(), INTERVAL 3 DAY) + INTERVAL 1 HOUR, 3, 1, 2, 2, 2, 3),

-- FUTUR mais complet (available_seats = 0) -> NE DOIT PAS apparaître
(DATE_ADD(NOW(), INTERVAL 2 DAY),  DATE_ADD(NOW(), INTERVAL 2 DAY) + INTERVAL 4 HOUR, 4, 0, 2, 2, 1, 3),

-- PASSÉ (departure_at < NOW) -> NE DOIT PAS apparaître
(DATE_SUB(NOW(), INTERVAL 2 DAY),  DATE_SUB(NOW(), INTERVAL 2 DAY) + INTERVAL 2 HOUR, 4, 2, 2, 2, 3, 1);
