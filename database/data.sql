INSERT INTO takalo_user_roles (libelle) VALUES 
('admin'),
('user');

INSERT INTO takalo_users (username, email, password_hash, id_role) VALUES 
('kevin', 'kev@gmail.com', '$2y$10$l3Mgzc8Qw8u4Z53MIdTlG.3NeyajmwQxPLFj7sW9gktL3x4S4dffy', 2),
('manoa', 'manoa@gmail.com', '$2y$10$l3Mgzc8Qw8u4Z53MIdTlG.3NeyajmwQxPLFj7sW9gktL3x4S4dffy', 2),
('admin', 'admin@admin.com', '$2y$10$l3Mgzc8Qw8u4Z53MIdTlG.3NeyajmwQxPLFj7sW9gktL3x4S4dffy', 1);

INSERT INTO takalo_item_categories (libelle) VALUES
('Électronique'),
('Vêtements'),
('Meubles'),
('Livres'),
('Jouets');

INSERT INTO takalo_items 
(title, description, id_category, id_owner, estimated_price) VALUES
('Smartphone Xiaomi', 'Smartphone Xiaomi Redmi Note 11 en bon état.', 1, 1, 150.00),
('Chaussures Nike', 'Chaussures de sport Nike taille 42, presque neuves.', 2, 2, 80.00),
('Table en bois', 'Table en bois massif pour salle à manger, état correct.', 3, 2, 120.00),
('Harry Potter Tome 1', 'Livre Harry Potter Tome 1, édition française.', 4, 1, 15.00),
('Lego City', 'Jeu de construction Lego City 2023, complet.', 5, 2, 60.00);

INSERT INTO takalo_item_photos (url,id_item) VALUES
('smartphone_1.jpg', 1),
('smartphone_2.jpg', 1),
('shoe_1.jpg', 2),
('shoe_2.jpg', 2),
('table_1.jpg', 3),
('movie_1.jpg', 4),
('toy_1.jpg', 5);

INSERT INTO takalo_demand_status (libelle) VALUES
('En attente'),
('Acceptée'),
('Refusée');