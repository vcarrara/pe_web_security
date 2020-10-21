DROP TABLE IF EXISTS USERS;

CREATE TABLE USERS (
    username varchar(64) PRIMARY KEY,
    pass varchar(64)
);

INSERT INTO USERS VALUES 
    ('john_doe', 'CroSS-SitE$John2020'), 
    ('super_jane', 'CroSS-SitE$Jane2020');