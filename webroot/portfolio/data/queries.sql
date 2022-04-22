CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(511) NOT NULL,
    email varchar(511) NOT NULL UNIQUE,
    password_hash varchar(255) NOT NULL,
    admin BOOLEAN DEFAULT FALSE,
    author BOOLEAN DEFAULT FALSE,
    PRIMARY KEY(id)
);

CREATE INDEX email_index ON users(email);
