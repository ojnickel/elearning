create database crud;
GRANT ALL ON crud.* TO 'fred'@'localhost' IDENTIFIED BY 'zap';
GRANT ALL ON crud.* TO 'fred'@'127.0.0.1' IDENTIFIED BY 'zap';

USE crud;

CREATE TABLE autos (
autos_id INT UNSIGNED NOT NULL AUTO_INCREMENT KEY,
make VARCHAR(255),
model VARCHAR(255),
year INTEGER,
mileage INTEGER
);
