CREATE DATABASE IF NOT EXISTS literie3000;

USE literie3000;


-- ----------------------------------


CREATE TABLE matelas (
    id TINYINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    reduction INT,
    picture VARCHAR(255)
);

CREATE TABLE marques (
    id TINYINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE dimensions (
    id TINYINT PRIMARY KEY AUTO_INCREMENT,
    dimension VARCHAR(100) NOT NULL
);



CREATE TABLE matelas_marques (
    matela_id TINYINT,
    marque_id TINYINT,
    FOREIGN KEY (matela_id) REFERENCES matelas(id),
    FOREIGN KEY (marque_id) REFERENCES marques(id),
    PRIMARY KEY (matela_id, marque_id)
);

CREATE TABLE matelas_dimensions (
    matela_id TINYINT,
    dimension_id TINYINT,
    FOREIGN KEY (matela_id) REFERENCES matelas(id),
    FOREIGN KEY (dimension_id) REFERENCES dimensions(id),
    PRIMARY KEY (matela_id, dimension_id)
);


-- ----------------------------------

INSERT INTO matelas
(name, price, reduction, picture)
VALUES
('Matelas Pas touché', 759, 0, 'pastouché.jpg'),
('Matelas Lapin', 809, 15, 'lapin.png'),
('Matelas Alejandrinho', 759, 30, 'alej.jpg'),
('Matelas Papy', 1019, 50, 'papy.jpg');

INSERT INTO marques
(name)
VALUES
('Epeda'),
('Dreamway'),
('Bultex'),
('Dorsoline'),
('MemoryLine');

INSERT INTO dimensions
(dimension)
VALUES
('90x190'),
('140x190'),
('160x200'),
('180x200'),
('200x200');

INSERT INTO matelas_marques
(matela_id, marque_id)
VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 1);

INSERT INTO matelas_dimensions
(matela_id, dimension_id)
VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 3);


-- ----------------------------------------------

-- pour vérifier la liaison :

SELECT matelas.name AS "Matelas", group_concat(marques.name SEPARATOR " - ") AS "Marques"
FROM matelas
INNER JOIN matelas_marques
ON matelas_marques.matela_id = matelas.id
inner join marques
on matelas_marques.marque_id = marques.id
group by matelas.name;

SELECT matelas.name AS "Matelas", group_concat(dimensions.dimension SEPARATOR " - ") AS "Dimensions"
FROM matelas
INNER JOIN matelas_dimensions
ON matelas_dimensions.matela_id = matelas.id
inner join dimensions
on matelas_dimensions.dimension_id = dimensions.id
group by matelas.name;