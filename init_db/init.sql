-- Création et utilisation de la base de données

CREATE DATABASE IF NOT EXISTS PE_SECURITY;
USE PE_SECURITY;

-- Création des tables

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

-- Insertion des données

INSERT INTO USERS VALUES 
    -- Utilisateurs avec mots de passe avec hash
    ('john_doe', '$2y$10$ZLO3lBfEFPmoTcUfXfP8iensaoMFcF13p2fMmYHIJFJzEDnsLVW9u'), 
    ('super_jane', '$2y$10$h6oYjRxxaoUSzBxUmU3CU.IeCqhCV6Rr4gZZ.mqbeD6XOksLJMu9e'),
    -- Utilisateurs avec mots de passe sans hash
    ('john_doe_injection', 'CroSS-SitE$John2020'), 
    ('super_jane_injection', 'CroSS-SitE$Jane2020');

INSERT INTO MESSAGES (mess, sender) VALUES ('Hi, I am John Doe, nice to meet you!', 'john_doe'), ('Hi John, my name is Jane!', 'super_jane'); 

-- Création d'un utilisateur et de ses droits associés

CREATE USER IF NOT EXISTS 'pe_user'@'%' IDENTIFIED BY 'pe_password';
GRANT SELECT ON PE_SECURITY.USERS TO 'pe_user'@'%';
GRANT INSERT ON PE_SECURITY.USERS TO 'pe_user'@'%';
GRANT SELECT ON PE_SECURITY.MESSAGES TO 'pe_user'@'%';
GRANT INSERT ON PE_SECURITY.MESSAGES TO 'pe_user'@'%';
FLUSH PRIVILEGES;