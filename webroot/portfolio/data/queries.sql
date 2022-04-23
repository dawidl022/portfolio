CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(511) NOT NULL,
    email VARCHAR(511) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    admin BOOLEAN DEFAULT FALSE,
    author BOOLEAN DEFAULT FALSE,
    PRIMARY KEY(id)
);

CREATE INDEX email_index ON users(email);

CREATE TABLE posts (
    id INT NOT NULL AUTO_INCREMENT,
    author_id INT,
    title VARCHAR(1024) NOT NULL,
    content TEXT NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    date_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP()
        ON UPDATE CURRENT_TIMESTAMP(),
    votes INT DEFAULT 0,

    PRIMARY KEY(id),
    FOREIGN KEY(author_id)
        REFERENCES users(id)
        ON DELETE SET NULL
);
