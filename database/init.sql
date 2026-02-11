DROP DATABASE IF EXISTS takalo;

CREATE DATABASE takalo;
\c takalo;

CREATE TABLE takalo_user_roles (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE takalo_users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    id_role INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_role) REFERENCES takalo_user_roles(id)
);

CREATE TABLE takalo_item_categories (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE takalo_items (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    id_category INT,
    id_owner INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estimated_price DECIMAL(10, 2),
    FOREIGN KEY (id_category) REFERENCES takalo_item_categories(id),
    FOREIGN KEY (id_owner) REFERENCES takalo_users(id)
);

CREATE TABLE takalo_item_photos (
    id SERIAL PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    id_item INT,
    FOREIGN KEY (id_item) REFERENCES takalo_items(id)
);

CREATE TABLE takalo_demand_status (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE takalo_demands (
    id SERIAL PRIMARY KEY,
    id_item1 INT,
    id_item2 INT,
    id_status INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_item1) REFERENCES takalo_items(id),
    FOREIGN KEY (id_item2) REFERENCES takalo_items(id),
    FOREIGN KEY (id_status) REFERENCES takalo_demand_status(id)
);

CREATE TABLE takalo_exchanges (
    id SERIAL PRIMARY KEY,
    id_item1 INT,
    id_item2 INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_item1) REFERENCES takalo_items(id),
    FOREIGN KEY (id_item2) REFERENCES takalo_items(id)
);

CREATE VIEW items_with_first_photo AS
SELECT ti.*, 
       tip.id as id_photo, 
       tip.url as photo_url,
       tu.username as owner_username,
       tu.email as owner_email,
       tic.libelle as category_libelle
FROM takalo_items ti 
JOIN takalo_item_photos tip ON ti.id = tip.id_item 
JOIN takalo_users tu ON ti.id_owner = tu.id
JOIN takalo_item_categories tic ON ti.id_category = tic.id
WHERE tip.id = (
    SELECT MIN(id) 
    FROM takalo_item_photos 
    WHERE id_item = ti.id
);