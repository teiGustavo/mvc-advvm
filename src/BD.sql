DROP SCHEMA IF EXISTS id19770428_bd_relatorio;
CREATE SCHEMA IF NOT EXISTS id19770428_bd_relatorio;
USE id19770428_bd_relatorio;

CREATE TABLE IF NOT EXISTS usuario(
	cod_usuario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(100) NOT NULL DEFAULT 'seuemail@email.com',
    senha VARCHAR(64) NOT NULL DEFAULT 'NÂO DEFINIDA',
    adm TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS reports(
	cod_lancamento INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    data_report DATE NOT NULL DEFAULT "2023-01-01",
    historico VARCHAR(100) NOT NULL DEFAULT 'INDEFINIDO',
    tipo VARCHAR(7) NOT NULL DEFAULT "TYPE",
    valor DOUBLE NOT NULL DEFAULT 0.0	
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