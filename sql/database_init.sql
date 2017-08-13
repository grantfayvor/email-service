CREATE DATABASE IF NOT EXISTS email_service;

USE email_service;

CREATE TABLE IF NOT EXISTS user (
    id                           INTEGER      NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name                   VARCHAR(50)  NOT NULL,
    last_name                    VARCHAR(50)  NOT NULL,
    username                     VARCHAR(50)  NOT NULL,
    password                	 VARCHAR(100) NOT NULL,
    email                        VARCHAR(100) NOT NULL,
    phone_number                 VARCHAR(50)  NOT NULL,
    account_type                 VARCHAR(50)  NOT NULL
);

CREATE TABLE IF NOT EXISTS email (
    id                          INTEGER      NOT NULL PRIMARY KEY AUTO_INCREMENT,
    sender_id                   INTEGER  	 NOT NULL,
    recipient_id                INTEGER		 NOT NULL,
    subject                     VARCHAR(50)  NOT NULL,
    message              		VARCHAR(255) NOT NULL,
    spam                        BOOLEAN      NOT NULL,
    date_sent                   TIMESTAMP    NOT NULL,
    FOREIGN KEY (sender_id) REFERENCES user (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES user (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

INSERT INTO `user`(`first_name`, `last_name`, `username`, `password`, `email`, `phone_number`, `account_type`) VALUES("admin", "admin", "admin", "5f4dcc3b5aa765d61d8327deb882cf99", "admin@email.com", "2348089706953", "ADMIN");