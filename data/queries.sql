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
    title VARCHAR(511) NOT NULL,
    permalink VARCHAR(511) NOT NULL UNIQUE,
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


CREATE TABLE comments (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT,
    post_id INT NOT NULL,
    in_reply_to INT,
    content TEXT NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    date_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP()
        ON UPDATE CURRENT_TIMESTAMP(),

    PRIMARY KEY(id),

    FOREIGN KEY(user_id)
        REFERENCES users(id)
        ON DELETE SET NULL,

    FOREIGN KEY(post_id)
        REFERENCES posts(id)
        ON DELETE CASCADE,

    FOREIGN KEY(in_reply_to)
        REFERENCES comments(id)
        ON DELETE CASCADE
);
