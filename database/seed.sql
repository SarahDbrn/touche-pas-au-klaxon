USE touche_pas_au_klaxon;

INSERT INTO agencies (name) VALUES
('Paris'),
('Lyon'),
('Marseille');

INSERT INTO users (lastname, firstname, email, phone, password, role) VALUES
('Admin', 'Super', 'admin@tpak.local', '0102030405', '$2y$10$XJer4k6VqicT0TdVPuU4vu9QDCzZnetvyTsHiZGY1MuXlgzxVI8BC', 'ADMIN'),
('Martin', 'Alex', 'alex@tpak.local', '0607080910', '$2y$10$XJer4k6VqicT0TdVPuU4vu9QDCzZnetvyTsHiZGY1MuXlgzxVI8BC', 'USER');
