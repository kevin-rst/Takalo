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

CREATE VIEW demands_with_items_first_photo AS
SELECT d.id AS demand_id,
       d.created_at AS demand_created_at,
       d.id_item1,
       d.id_item2,
       d.id_status,
       ds.libelle AS status_libelle,
       i1.id AS item1_id,
       i1.title AS item1_title,
       i1.description AS item1_description,
       i1.id_category AS item1_id_category,
       i1.id_owner AS item1_id_owner,
       i1.created_at AS item1_created_at,
       i1.estimated_price AS item1_estimated_price,
       i1.id_photo AS item1_id_photo,
       i1.photo_url AS item1_photo_url,
       i1.owner_username AS item1_owner_username,
       i1.owner_email AS item1_owner_email,
       i1.category_libelle AS item1_category_libelle,
       i2.id AS item2_id,
       i2.title AS item2_title,
       i2.description AS item2_description,
       i2.id_category AS item2_id_category,
       i2.id_owner AS item2_id_owner,
       i2.created_at AS item2_created_at,
       i2.estimated_price AS item2_estimated_price,
       i2.id_photo AS item2_id_photo,
       i2.photo_url AS item2_photo_url,
       i2.owner_username AS item2_owner_username,
       i2.owner_email AS item2_owner_email,
       i2.category_libelle AS item2_category_libelle
FROM takalo_demands d
JOIN takalo_demand_status ds ON d.id_status = ds.id
JOIN items_with_first_photo i1 ON d.id_item1 = i1.id
JOIN items_with_first_photo i2 ON d.id_item2 = i2.id;