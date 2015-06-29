DROP DATABASE IF EXISTS User;
CREATE DATABASE IF NOT EXISTS User;


DROP TABLE IF EXISTS User.user;

CREATE TABLE User.user(
  id INT(7) NOT NULL AUTO_INCREMENT, 
  username VARCHAR(100) UNIQUE,
  password VARCHAR(100) NOT NULL,
  actived BOOLEAN,
  deleted BOOLEAN,
  date_deletion date,
  PRIMARY KEY (id),
  CONSTRAINT uc_username UNIQUE (username)
  );


   /*insert some clients to client table*/
	INSERT INTO user.user
	VALUES (default, 'test1', 'test1', true, false, null);

	INSERT INTO user.user
	VALUES (default, 'test2', 'test2', true, false, null);

	INSERT INTO user.user
	VALUES (default, 'test3', 'test3', true, false, null);
SELECT * FROM user.user;
SET GLOBAL general_log_file = "C:/log.log";
SET GLOBAL general_log = 'ON';

DELETE FROM user.user
WHERE username = 'test1';