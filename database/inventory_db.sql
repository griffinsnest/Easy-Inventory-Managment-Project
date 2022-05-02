drop database if exists inventory_db;
create database inventory_db;

use inventory_db;

DROP TABLE IF EXISTS products;
CREATE TABLE IF NOT EXISTS products (
  product_id int NOT NULL AUTO_INCREMENT,
  product_name varchar(255) NOT NULL,
  stock int NOT NULL,
  low_stock int DEFAULT NULL,
  unit varchar(32) DEFAULT NULL,
  PRIMARY KEY (product_id)
);

--
-- Dumping data for table products
--

INSERT INTO products (product_id, product_name, stock, low_stock, unit) VALUES
('1', 'Example Item', '99', '1', 'Units');


-- --------------------------------------------------------

--
-- Table structure for table users
--

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
  user_id int NOT NULL AUTO_INCREMENT,
  email varchar(255) NOT NULL,
  first_name varchar(255) NOT NULL,
  last_name varchar(255) NOT NULL,
  PASSWORD char(128) NOT NULL,
  user_type tinyint(1) NOT NULL,
  PRIMARY KEY (user_id)
);

INSERT INTO users (user_id, email, first_name, last_name, PASSWORD, user_type) VALUES
('1', 'MASTER', 'MASTER', 'ACCOUNT', sha2('Password', 256), '1');

-- --------------------------------------------------------

DROP TABLE IF EXISTS users;
CREATE TABLE password_reset (
  email varchar(250) NOT NULL,
  link varchar(250) NOT NULL,
  expDate datetime NOT NULL
);