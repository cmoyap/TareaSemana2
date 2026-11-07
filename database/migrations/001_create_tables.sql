CREATE TABLE IF NOT EXISTS products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    description TEXT NULL,
    price NUMERIC(10,2) NOT NULL DEFAULT 0,
    stock INTEGER NOT NULL DEFAULT 0,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
create table if not exists users (
    id serial primary key,
    name varchar(120) not null,
    email varchar(120) not null unique,
    password varchar(255) not null,
    created_at timestamp not null default current_timestamp
);