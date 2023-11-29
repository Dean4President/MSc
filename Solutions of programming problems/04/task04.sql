CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(30) NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT username_uq UNIQUE(username)
) CHARSET=utf8 COLLATE utf8_hungarian_ci;

INSERT INTO users (username, password) VALUES ('kiskacsa', '12345');
INSERT INTO users (username, password) VALUES ('helo', 'helo');

CREATE TABLE games (
    game_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    guesses INT NOT NULL,
    PRIMARY KEY(game_id),
    CONSTRAINT user_fk FOREIGN KEY(user_id) REFERENCES users(id)
) CHARSET=utf8 COLLATE utf8_hungarian_ci;

SELECT users.username, COUNT(games.user_id) as NumberOfGames, ROUND(AVG(games.guesses), 2) AS AverageGuess
FROM games
INNER JOIN users USING(user_id)
GROUP BY games.user_id
ORDER BY AverageGuess ASC, NumberOfGames DESC;