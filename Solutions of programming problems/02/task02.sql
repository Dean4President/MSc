CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(30) NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT username_uq UNIQUE(username)
) CHARSET=utf8 COLLATE utf8_hungarian_ci;

INSERT INTO users (username, password) VALUES ('kiskacsa', '12345');
INSERT INTO users (username, password) VALUES ('helo', 'helo');