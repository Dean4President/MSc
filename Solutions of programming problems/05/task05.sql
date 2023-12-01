DROP TABLE IF EXISTS news;
DROP TABLE IF EXISTS games;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(30) NOT NULL,
    is_admin BOOLEAN NOT NULL,
    PRIMARY KEY(user_id),
    CONSTRAINT username_uq UNIQUE(username)
) CHARSET=utf8 COLLATE utf8_hungarian_ci;

INSERT INTO users (username, password, is_admin) VALUES ('kiskacsa', '12345', 1);
INSERT INTO users (username, password, is_admin) VALUES ('helo', 'helo', 0);

CREATE TABLE games (
    game_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    guesses INT NOT NULL,
    PRIMARY KEY(game_id),
    CONSTRAINT g_u_fk FOREIGN KEY(user_id) REFERENCES users(user_id)
) CHARSET=utf8 COLLATE utf8_hungarian_ci;

INSERT INTO games (user_id, guesses) VALUES (1, 6);
INSERT INTO games (user_id, guesses) VALUES (1, 7);
INSERT INTO games (user_id, guesses) VALUES (2, 6);
INSERT INTO games (user_id, guesses) VALUES (2, 7);
INSERT INTO games (user_id, guesses) VALUES (2, 7);

CREATE TABLE news (
    news_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    newsbody TEXT NOT NULL,
    PRIMARY KEY(news_id),
    CONSTRAINT n_u_fk FOREIGN KEY(user_id) REFERENCES users(user_id)
) CHARSET=utf8 COLLATE utf8_hungarian_ci;

INSERT INTO news (user_id, title, newsbody) VALUES (1, "First post", "This is a test. This is the first post on this site");
INSERT INTO news (user_id, title, newsbody) VALUES (2, "Lorem ipsum", "Lorem ipsum dolor sit amet.");