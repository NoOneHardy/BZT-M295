DROP DATABASE IF EXISTS M295;
CREATE DATABASE IF NOT EXISTS M295;
USE M295;

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    price INT,
    kraftstoff VARCHAR(255),
    farbe VARCHAR(7),
    bauart VARCHAR(255),
    tank INT,
    jahrgang DATE,
    createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    active TINYINT NOT NULL DEFAULT 1
);

INSERT INTO cars (name, price, kraftstoff, farbe, bauart, tank, jahrgang) VALUES
('Audi', 52642, 'Diesel', '#00ffff', 'Limousine', 0, '2019-08-07'),
('BMW', 60000, 'Benzin', '#ff0000', 'SUV', 0, '2018-07-06'),
('Mercedes', 70000, 'Diesel', '#00ff00', 'Limousine', 0, '2017-06-05'),
('Volkswagen', 50000, 'Benzin', '#0000ff', 'Kombi', 0, '2016-05-04'),
('Porsche', 80000, 'Diesel', '#ffff00', 'Sportwagen', 0, '2015-04-03'),
('Opel', 40000, 'Benzin', '#ff00ff', 'Kleinwagen', 0, '2014-03-02'),
('Ford', 45000, 'Diesel', '#00ffff', 'Limousine', 0, '2013-02-01'),
('Fiat', 35000, 'Benzin', '#ff0000', 'Kombi', 0, '2012-01-31'),
('Peugeot', 40000, 'Diesel', '#00ff00', 'SUV', 0, '2011-12-30'),
('Renault', 45000, 'Benzin', '#0000ff', 'Sportwagen', 0, '2010-11-29'),
('Tesla', 45000, 'Elektro', '#0000ff', 'Sportwagen', 0, '2015-10-23');
