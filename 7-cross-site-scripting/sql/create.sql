CREATE TABLE USERS (
    username varchar(64) PRIMARY KEY,
    pass varchar(64)
);

CREATE TABLE MESSAGES (
    id int PRIMARY KEY AUTO_INCREMENT,
    mess varchar(256),
    sender varchar(64),
    FOREIGN KEY (sender) REFERENCES USERS(username)
);