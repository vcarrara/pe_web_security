DROP TABLE IF EXISTS USERS;

CREATE TABLE USERS (
    username varchar(64) PRIMARY KEY,
    pass varchar(64)
);

INSERT INTO USERS VALUES 
    ('john_doe', '$2y$10$ZLO3lBfEFPmoTcUfXfP8iensaoMFcF13p2fMmYHIJFJzEDnsLVW9u'), 
    ('super_jane', '$2y$10$h6oYjRxxaoUSzBxUmU3CU.IeCqhCV6Rr4gZZ.mqbeD6XOksLJMu9e');