INSERT INTO takalo_roles (libelle) VALUES 
('Admin'),
('Membre'),
('Modérateur');

INSERT INTO takalo_users (username, email, password_hash, id_role) VALUES 
('jean_dupont', 'jean.dupont@email.com', 'motdepasse123', 2),
('marie_martin', 'marie.martin@email.com', 'secure456', 2),
('admin_system', 'admin@takalo.com', 'admin789', 1),
('pierre_durand', 'pierre.durand@email.com', 'pierre123', 2);

INSERT INTO takalo_item_categories (libelle) VALUES 
('Électronique'),
('Vêtements'),
('Livres'),
('Jeux vidéo');

INSERT INTO takalo_item_photos (url) VALUES 
('https://example.com/photos/iphone12.jpg'),
('https://example.com/photos/veste_cuir.jpg'),
('https://example.com/photos/harry_potter.jpg'),
('https://example.com/photos/ps5.jpg');

INSERT INTO takalo_demand_status (libelle) VALUES 
('En attente'),
('Acceptée'),
('Refusée'),
('Annulée');

INSERT INTO takalo_items (title, description, id_category, id_owner, id_photo, estimated_price) VALUES 
('iPhone 12', 'Smartphone Apple en très bon état, 128Go', 1, 1, 1, 450.00),
('Veste en cuir', 'Veste taille M, couleur noire, légèrement portée', 2, 2, 2, 80.00),
('Harry Potter Tome 1', 'Livre en bon état, édition française', 3, 3, 3, 10.00),
('PS5', 'Console PlayStation 5, avec une manette', 4, 4, 4, 350.00),
('MacBook Pro', 'MacBook Pro 13 pouces, 256Go, 2020', 1, 1, NULL, 900.00),
('Jeans Levis', 'Jeans taille 32/32, très bon état', 2, 2, NULL, 35.00);

INSERT INTO takalo_demands (id_item1, id_item2, id_status) VALUES 
(1, 4, 1),  -- Jean veut échanger son iPhone contre la PS5 de Pierre
(2, 6, 2),  -- Marie veut échanger sa veste contre le jeans (accepté)
(3, 5, 3),  -- Admin veut échanger Harry Potter contre MacBook (refusé)
(4, 1, 1);  -- Pierre veut échanger sa PS5 contre l'iPhone de Jean

INSERT INTO takalo_demands (id_item1, id_item2, id_status) VALUES 
(5, 3, 1),  -- Jean veut échanger son MacBook contre Harry Potter
(6, 2, 2);  -- Marie veut échanger son jeans contre la veste (accepté)

INSERT INTO takalo_exchanges (id_item1, id_item2) VALUES 
(1, 4),  -- Échange entre Jean et Pierre
(2, 6);  -- Échange entre Marie et l'autre utilisateur