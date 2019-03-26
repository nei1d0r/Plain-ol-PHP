CREATE TABLE users (
id INT(11) NOT NULL AUTO_INCREMENT,
first_name VARCHAR(255) NOT NULL,
last_name VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
street VARCHAR(255) NOT NULL,
town VARCHAR(255) NOT NULL,
city VARCHAR(255) NOT NULL,
postcode VARCHAR(8) NOT NULL,
password VARCHAR(255) NOT NULL,
registered DATETIME NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE admins (
id INT(11) NOT NULL AUTO_INCREMENT,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE events (
id INT(11) NOT NULL AUTO_INCREMENT,
event_name VARCHAR(255) NOT NULL,
PRIMARY KEY (id)
);

## USER EVENTS

CREATE TABLE user_events (
user_id INT(11) NOT NULL,
event_id INT(11) NOT NULL,
event_date DATE NOT NULL,
result VARCHAR(10),
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (event_id) REFERENCES events(id)
);

-- JUST TO ADD SOME DATA FOR TESTS
INSERT INTO user_events (user_id, event_id, event_date, result)
VALUES (1,3,"2019/03/24","1:10:11");

-- CREATE JOIN TO DISPLAY FOLLOWING TABLE --
-- first_name, last_name, event_name, event_date, result

SELECT u.first_name, u.last_name, e.event_name, ue.event_date, ue.result
FROM users as u INNER JOIN user_events as ue
ON u.id = ue.user_id
INNER JOIN events as e
ON e.id = ue.event_id
WHERE user_id = 1
ORDER by ue.result DESC;


