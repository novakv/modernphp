CREATE DATABASE ecommerce;

USE ecommerce;

CREATE TABLE klanten (
  klant_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(40) NOT NULL,
  wachtwoord CHAR(40) NOT NULL,
  voornaam VARCHAR(20) NOT NULL,
  achternaam VARCHAR(30) NOT NULL,
  adres1 VARCHAR(60) NOT NULL,
  adres2 VARCHAR(60),
  postcode VARCHAR(7) NOT NULL,
  plaats VARCHAR(30) NOT NULL,
  telefoon VARCHAR(15),
  PRIMARY KEY (klant_id),
  UNIQUE (email),
  KEY email_wachtwoord (email, wachtwoord)
) ENGINE=MyISAM;

CREATE TABLE orders (
  order_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  klant_id INT(5) UNSIGNED NOT NULL,
  totaal DECIMAL(10,2) NOT NULL,
  orderdatum TIMESTAMP,
  PRIMARY KEY (order_id),
  KEY klant_id (klant_id),
  KEY orderdatum (orderdatum)
) ENGINE=InnoDB;

CREATE TABLE orderinhoud (
  orderinhoud_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  order_id INT UNSIGNED NOT NULL,
  specifieke_widgets_id INT UNSIGNED NOT NULL,
  aantal TINYINT UNSIGNED NOT NULL DEFAULT 1,
  prijs DECIMAL(6,2) NOT NULL,
  verzenddatum DATETIME default NULL,
  PRIMARY KEY (orderinhoud_id),
  KEY order_id (order_id),
  KEY specifieke_widgets_id (specifieke_widgets_id),
  KEY verzenddatum (verzenddatum)
) ENGINE=InnoDB;

CREATE TABLE categorieen (
  categorie_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  categorie VARCHAR(30) NOT NULL,
  beschrijving TEXT,
  PRIMARY KEY (categorie_id)
) ENGINE=MyISAM;

CREATE TABLE kleuren (
  kleur_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  kleur VARCHAR(11) NOT NULL,
  PRIMARY KEY (kleur_id)
) ENGINE=MyISAM;

CREATE TABLE maten (
  maat_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  maat VARCHAR(10) NOT NULL,
  PRIMARY KEY (maat_id)
) ENGINE=MyISAM;

CREATE TABLE algemene_widgets (
  algemene_widgets_id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  categorie_id TINYINT UNSIGNED NOT NULL,
  naam VARCHAR(30) NOT NULL,
  standaardprijs DECIMAL(6,2) NOT NULL,
  beschrijving TEXT,
  PRIMARY KEY (algemene_widgets_id),
  UNIQUE (naam),
  KEY (categorie_id)
) ENGINE=MyISAM;

CREATE TABLE specifieke_widgets (
  specifieke_widgets_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  algemene_widgets_id MEDIUMINT UNSIGNED NOT NULL,
  kleur_id TINYINT UNSIGNED NOT NULL,
  maat_id TINYINT UNSIGNED NOT NULL,
  prijs DECIMAL(6,2),
  op_voorraad CHAR(1),
  PRIMARY KEY (specifieke_widgets_id),
  UNIQUE combo (algemene_widgets_id, kleur_id, maat_id),
  KEY (algemene_widgets_id),
  KEY (kleur_id),
  KEY (maat_id)
) ENGINE=MyISAM;

GRANT ALL PRIVILEGES ON ecommerce.* TO 'winkel'@'%' IDENTIFIED BY 'brobbeltje' WITH GRANT OPTION;

INSERT INTO categorieen (categorie) VALUES
  ('Widgets die wiebelen'),
  ('Widgets die stuiteren'),
  ('Widgets die stilstaan'),
  ('Widget-loze widgets'),
  ('Snoezige widgets'),
  ('Messcherpe widgets');

INSERT INTO kleuren (kleur) VALUES
  ('Rood'),
  ('Blauw'),
  ('Pimpelpaars'),
  ('Steengrijs'),
  ('Stofbruin'),
  ('Modderbruin');

INSERT INTO maten (maat) VALUES
  ('Piepklein'),
  ('Klein'),
  ('Groot'),
  ('Gigantisch'),
  ('Medium'),
  ('Venti');

INSERT INTO algemene_widgets (categorie_id, naam, standaardprijs, beschrijving) VALUES
  (1, 'Wiebel Widget 1', 234.45, 'Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. '),
  (1, 'Wiebel Widget 2', 200.99, 'Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. '),
  (1, 'Wiebel Widget 3', 164.00, 'Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. '),
  (2, 'Stuiter Widget 1', 1.16, 'Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. '),
  (2, 'Stuiter Widget 2', 32.20, 'Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. '),
  (3, 'Nutteloze Widget', 985.00, 'Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. '),
  (6, 'Prikkeldraad Widget', 141.66, 'Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. '),
  (6, 'Roestige Spijkers Widget', 45.25, 'Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. '),
  (6, 'Gebroken Glas Widget', 8.00, 'Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. Dit is de beschrijving van deze widget. ');

INSERT INTO specifieke_widgets (algemene_widgets_id, kleur_id, maat_id, prijs, op_voorraad) VALUES
  (1, 1, 2, NULL, 'J'),
  (1, 1, 3, NULL, 'J'),
  (1, 1, 4, NULL, 'J'),
  (1, 3, 1, NULL, 'J'),
  (1, 3, 2, NULL, 'J'),
  (1, 4, 1, NULL, 'J'),
  (1, 4, 2, NULL, 'N'),
  (1, 4, 3, NULL, 'N'),
  (1, 4, 6, NULL, 'J'),
  (2, 1, 1, NULL, 'J'),
  (2, 1, 2, NULL, 'J'),
  (2, 1, 6, NULL, 'N'),
  (2, 4, 4, NULL, 'J'),
  (2, 4, 5, NULL, 'J'),
  (2, 6, 1, NULL, 'N'),
  (2, 6, 2, NULL, 'J'),
  (2, 6, 3, NULL, 'J'),
  (2, 6, 6, NULL, 'J'),
  (3, 1, 1, 123.45, 'N'),
  (3, 1, 2, NULL, 'J'),
  (3, 1, 6, 846.45, 'J'),
  (3, 1, 4, NULL, 'J'),
  (3, 4, 4, NULL, 'J'),
  (3, 4, 5, 147.00, 'J'),
  (3, 6, 1, 196.50, 'J'),
  (3, 6, 2, 202.54, 'J'),
  (3, 6, 3, NULL, 'N'),
  (3, 6, 6, NULL, 'J'),
  (4, 2, 5, NULL, 'J'),
  (4, 2, 6, NULL, 'J'),
  (4, 3, 2, NULL, 'N'),
  (4, 3, 3, NULL, 'J'),
  (4, 3, 6, NULL, 'J'),
  (4, 5, 4, NULL, 'J'),
  (4, 5, 6, NULL, 'N'),
  (4, 6, 2, NULL, 'J'),
  (4, 6, 3, NULL, 'J');