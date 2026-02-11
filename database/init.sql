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

CREATE TABLE takalo_item_photos (
    id SERIAL PRIMARY KEY,
    url VARCHAR(255) NOT NULL
);

CREATE TABLE takalo_items (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    id_category INT,
    id_owner INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_photo INT,
    estimated_price DECIMAL(10, 2),
    FOREIGN KEY (id_category) REFERENCES takalo_item_categories(id),
    FOREIGN KEY (id_owner) REFERENCES takalo_users(id),
    FOREIGN KEY (id_photo) REFERENCES takalo_item_photos(id)
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