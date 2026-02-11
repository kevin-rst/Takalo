INSERT INTO takalo_user_roles (libelle) VALUES 
('admin'),
('user');

INSERT INTO takalo_users (username, email, password_hash, id_role) VALUES 
('admin', 'admin@admin.com', '$2y$10$l3Mgzc8Qw8u4Z53MIdTlG.3NeyajmwQxPLFj7sW9gktL3x4S4dffy', 1);