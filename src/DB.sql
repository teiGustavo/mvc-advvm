DROP SCHEMA IF EXISTS reports;
CREATE SCHEMA IF NOT EXISTS reports;
USE reports;

CREATE TABLE IF NOT EXISTS users(
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	EMAIL VARCHAR(100) NOT NULL DEFAULT 'seuemail@email.com',
    PASSWD VARCHAR(64) NOT NULL DEFAULT 'NÂO DEFINIDA',
    ADM TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS reports(
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    DATE_REPORT DATE NOT NULL DEFAULT "2023-01-01",
    RECORD VARCHAR(100) NOT NULL DEFAULT 'INDEFINIDO',
    TYPE VARCHAR(7) NOT NULL DEFAULT "TYPE",
    VALOR DOUBLE NOT NULL DEFAULT 0.0	
);

INSERT INTO usuario(email, senha, adm) VALUES ('adm@adm.adm', md5('adm'), 1);
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();
INSERT INTO reports() VALUES ();