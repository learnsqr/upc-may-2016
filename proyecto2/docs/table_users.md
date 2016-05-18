#CREATE TABLE USERS

CREATE TABLE users ( iduser varchar(255) NOT NULL, email varchar(100) NOT NULL, password varchar(255) NOT NULL, PRIMARY KEY (iduser) ); 
INSERT INTO users (iduser, email, password) VALUES ('kaka', 'user1', 'pwd1'); 