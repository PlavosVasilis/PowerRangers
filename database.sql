DROP DATABASE IF EXISTS energy_wallet;


CREATE DATABASE energy_wallet;



CREATE TABLE IF NOT EXISTS energy_wallet.USERS(
id int(50) UNSIGNED AUTO_INCREMENT,
username VARCHAR(50) NOT NULL,
password VARCHAR(50) NOT NULL, # must be hashed
account_id VARCHAR(200) NOT NULL,
IBAN VARCHAR(100) NOT NULL,
PRIMARY KEY (id)
);




CREATE TABLE IF NOT EXISTS energy_wallet.ORDERS(
id int(50) UNSIGNED AUTO_INCREMENT,
user_id int(50) UNSIGNED,
price DECIMAL(5,5) NOT NULL,
volume DOUBLE(8,4) NOT NULL,
side CHAR(1) NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (user_id) REFERENCES USERS(id)
);



DESCRIBE energy_wallet.USERS;

DESCRIBE energy_wallet.ORDERS;


# Insert Users :
INSERT INTO energy_wallet.USERS (username, password, account_id, IBAN)
VALUES ('tassos', '123456789', '4dc56df2-3519-4c81-a83a-04076b66abc0', 'GR4501101030000010348012377');

INSERT INTO energy_wallet.USERS (username, password, account_id, IBAN)
VALUES ('Maya', '123456789', '4dc56df2-3519-4c81-a83a-04076b66abc0', 'GR0901109720000097226400154');

INSERT INTO energy_wallet.USERS (username, password, account_id, IBAN)
VALUES ('vasilis', '123456789', '4dc56df2-3519-4c81-a83a-04076b66abc0', 'GR09011972043297226499');


# Insert Orders:
INSERT INTO energy_wallet.ORDERS (user_id, price, volume, side)
VALUES ('1', 0.08, 10, 'B');

INSERT INTO energy_wallet.ORDERS (user_id, price, volume, side)
VALUES ('1', 0.11, 100, 'B');

INSERT INTO energy_wallet.ORDERS (user_id, price, volume, side)
VALUES ('1', 0.09, 30, 'S');

INSERT INTO energy_wallet.ORDERS (user_id, price, volume, side)
VALUES ('2', 0.07, 20, 'B');

INSERT INTO energy_wallet.ORDERS (user_id, price, volume, side)
VALUES ('2', 0.07, 15, 'S');

INSERT INTO energy_wallet.ORDERS (user_id, price, volume, side)
VALUES ('3', 0.08, 50, 'B');

INSERT INTO energy_wallet.ORDERS (user_id, price, volume, side)
VALUES ('3', 0.11, 90, 'S');


# View :
SELECT * FROM energy_wallet.ORDERS;
SELECT price, volume FROM energy_wallet.ORDERS WHERE side='B' order by price DESC;
SELECT price, volume FROM energy_wallet.ORDERS WHERE side='S' order by price DESC;

