CREATE TABLE Obsluga (
  id INTEGER PRIMARY KEY,
  imie VARCHAR(15) NOT NULL,
  nazwisko VARCHAR(20) NOT NULL,
  login VARCHAR(15) NOT NULL,
  haslo VARCHAR(15) NOT NULL,
  pensja NUMERIC(7,2)
);

INSERT INTO Obsluga VALUES(1,'Pawe³',   'Polo',			'PawelP',		'haslo1', 800.00);
INSERT INTO Obsluga VALUES(2,'Weronika','Ró¿a', 		'WeronikaR',	'haslo2', 1200.00);
INSERT INTO Obsluga VALUES(3,'Piotr',   'Opal',      	'PiotrO', 		'haslo3', 900.00);
INSERT INTO Obsluga VALUES(4,'Fryderyk','Nowy',     	'Fryderyk', 	'haslo4', 1300.00);
INSERT INTO Obsluga VALUES(5,'Anna',    'Zbierska',  	'AnnaZ', 		'haslo5', 890.00);
INSERT INTO Obsluga VALUES(6,'Gra¿yna', 'Wierska',   	'GrazynaW', 	'haslo6', 800.00);
INSERT INTO Obsluga VALUES(7,'Jan',     'Ko³o',      	'JanK', 		'haslo7', 1000.00);
INSERT INTO Obsluga VALUES(8,'Karol',   'Wszêdobylski', 'KarolW', 		'haslo8', 1350.00);
INSERT INTO Obsluga VALUES(9,'Pawe³',   'Os³owski',   	'PawelO', 		'haslo9', 1400.00);

CREATE TABLE Administratorzy (
  id INTEGER PRIMARY KEY,
  imie VARCHAR(15) NOT NULL,
  nazwisko VARCHAR(20) NOT NULL,
  login VARCHAR(15) NOT NULL,
  haslo VARCHAR(15) NOT NULL,
  pensja NUMERIC(7,2)
);

INSERT INTO Administratorzy VALUES(1,'Administrator',   'Admin',	'AdminA',	'haslo', 2000.00);

CREATE TABLE Pokoje (
  numer CHAR(3) PRIMARY KEY,
  ilu_osobowy CHAR(1),
  lazienka CHAR(1) CHECK (lazienka IN ( 'Y', 'N' )),
  cena NUMERIC(6,2)
);

INSERT INTO Pokoje VALUES('101','2','Y', 120.00);
INSERT INTO Pokoje VALUES('102','1','N', 80.00);
INSERT INTO Pokoje VALUES('103','1','Y',  80.00);
INSERT INTO Pokoje VALUES('104','2','N',120.00);
INSERT INTO Pokoje VALUES('105','2','N',120.00);
INSERT INTO Pokoje VALUES('106','3','Y',145.00);
INSERT INTO Pokoje VALUES('107','2','Y',120.00);
INSERT INTO Pokoje VALUES('108','1','N', 80.00);
INSERT INTO Pokoje VALUES('109','1','N', 80.00);
INSERT INTO Pokoje VALUES('110','1','N', 80.00);
INSERT INTO Pokoje VALUES('201','2','Y', 120.00);
INSERT INTO Pokoje VALUES('202','2','N',120.00);
INSERT INTO Pokoje VALUES('203','2','Y',120.00);
INSERT INTO Pokoje VALUES('204','2','N',120.00);
INSERT INTO Pokoje VALUES('205','3','Y', 145.00);
INSERT INTO Pokoje VALUES('206','3','N',145.00);
INSERT INTO Pokoje VALUES('207','2','Y', 120.00);
INSERT INTO Pokoje VALUES('208','2','N',120.00);
INSERT INTO Pokoje VALUES('209','1','Y', 80.00);
INSERT INTO Pokoje VALUES('210','1','Y',  80.00);
INSERT INTO Pokoje VALUES('301','1','N', 80.00);
INSERT INTO Pokoje VALUES('302','1','N', 80.00);
INSERT INTO Pokoje VALUES('303','2','Y', 120.00);
INSERT INTO Pokoje VALUES('304','2','N',120.00);
INSERT INTO Pokoje VALUES('305','1','Y', 80.00);
INSERT INTO Pokoje VALUES('306','2','Y', 120.00);
INSERT INTO Pokoje VALUES('307','1','Y', 80.00);
INSERT INTO Pokoje VALUES('308','1','Y', 80.00);

CREATE TABLE Goscie (
  id INTEGER PRIMARY KEY,
  imie VARCHAR(15) NOT NULL,
  nazwisko VARCHAR(20) NOT NULL,
  login VARCHAR(15) NOT NULL,
  haslo VARCHAR(40) NOT NULL,
  karta_kredytowa CHAR(6)
);

INSERT INTO Goscie VALUES( 1,'Adam',      'Kot',  		'AdamK', 	 	'cbac16609bc705ef460f6cc4d68555e532113c02',   '123356');
INSERT INTO Goscie VALUES( 2,'Dariusz',   'Bach',   	'DariuszB',		'haslo2', 	'345678');
INSERT INTO Goscie VALUES( 3,'Pawe³',     'Bilowski', 	'PawelB',		'haslo3', 	'987545');
INSERT INTO Goscie VALUES( 4,'Arkadiusz', '£ebacki',  	'ArkadiuszL', 	'haslo4', 	'198722');
INSERT INTO Goscie VALUES( 5,'Albin',     'Bizonowski',	'AlbinB', 		'haslo5', 	'342143');
INSERT INTO Goscie VALUES( 6,'Korneliusz','Pac',     	'KorneliuszP', 	'haslo6',   '156212');
INSERT INTO Goscie VALUES( 7,'Anna',      'By³a',     	'AnnaB', 		'haslo7', 	'190223');
INSERT INTO Goscie VALUES( 8,'Wac³aw',    'Z³y',      	'WaclawZ', 		'haslo8', 	'123777');
INSERT INTO Goscie VALUES( 9,'Piotr',     'Dobry',    	'PiotrD', 		'haslo9', 	'165342');
INSERT INTO Goscie VALUES(10,'Katarzyna', 'Bobrowska',	'KatarzynaB', 	'haslo10', 	'187635');
INSERT INTO Goscie VALUES(11,'Karolina',  'W¹glik',   	'KarolinaW', 	'haslo11', 	'142553');
INSERT INTO Goscie VALUES(12,'Barbara',   'Kwiatowska',	'BarbaraK', 	'haslo12',	'123433');
INSERT INTO Goscie VALUES(13,'Jan',       'Janowski',  	'JanJ', 		'haslo13',	'162733');
INSERT INTO Goscie VALUES(14,'Kamil',     'Ostry',     	'KamilO', 		'haslo14',	'199282');
INSERT INTO Goscie VALUES(15,'Ludwig',    'Œpiewny',   	'LudwigS', 		'haslo15',	'142523');
INSERT INTO Goscie VALUES(16,'Zenobia',   'Zenon',     	'ZenobiaZ', 	'haslo16',	'123865');

CREATE TABLE Rezerwacje (
  numer_rezerwacji INTEGER PRIMARY KEY,
  numer CHAR(3) REFERENCES Pokoje NOT NULL,
  id_goscia INTEGER REFERENCES Goscie NOT NULL,
  id_obslugi INTEGER REFERENCES Obsluga,
  od_kiedy DATE NOT NULL,
  do_kiedy DATE NOT NULL,
  zaplata CHAR(1) CHECK (zaplata IN ( 'Y', 'N' )),
  klucz CHAR(1) CHECK (klucz IN ( 'Y', 'N' ))
);

INSERT INTO Rezerwacje VALUES( 1,'101',1,1,to_date('2013-05-17','YYYY-MM-DD'),to_date('2013-05-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 2,'102',2,2,to_date('2013-12-06','YYYY-MM-DD'),to_date('2013-06-15','YYYY-MM-DD'),'N','N');
INSERT INTO Rezerwacje VALUES( 3,'103',3,7,to_date('2013-11-04','YYYY-MM-DD'),to_date('2013-01-04','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 4,'104',3,3,to_date('2013-12-03','YYYY-MM-DD'),to_date('2013-12-23','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 5,'105',4,4,to_date('2013-01-02','YYYY-MM-DD'),to_date('2013-12-02','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 6,'106',4,4,to_date('2013-09-09','YYYY-MM-DD'),to_date('2013-09-11','YYYY-MM-DD'),'N','N');
INSERT INTO Rezerwacje VALUES( 7,'10',5,5,to_date('2013-10-10','YYYY-MM-DD'),to_date('2013-10-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 8,'201',6,6,to_date('2013-05-04','YYYY-MM-DD'),to_date('2013-06-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 9,'202',3,8,to_date('2013-08-23','YYYY-MM-DD'),to_date('2013-08-30','YYYY-MM-DD'),'Y','N');
INSERT INTO Rezerwacje VALUES(10,'203',3,3,to_date('2013-01-02','YYYY-MM-DD'),to_date('2013-02-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(11,'204',2,2,to_date('2013-02-02','YYYY-MM-DD'),to_date('2013-02-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(12,'205',2,9,to_date('2013-03-03','YYYY-MM-DD'),to_date('2013-03-23','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(13,'206',1,1,to_date('2013-03-04','YYYY-MM-DD'),to_date('2013-04-04','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(14,'207',1,9,to_date('2013-05-05','YYYY-MM-DD'),to_date('2013-05-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(15,'301',2,5,to_date('2013-06-06','YYYY-MM-DD'),to_date('2013-06-10','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(16,'302',2,2,to_date('2013-07-07','YYYY-MM-DD'),to_date('2013-07-09','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(17,'303',1,4,to_date('2013-08-08','YYYY-MM-DD'),to_date('2013-08-23','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(18,'204',3,3,to_date('2013-09-09','YYYY-MM-DD'),to_date('2013-10-10','YYYY-MM-DD'),'Y','Y');

/*
INSERT INTO Rezerwacje VALUES( 1,'101',1,1,to_date('2002-05-17','YYYY-MM-DD'),to_date('2013-05-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 2,'102',2,2,to_date('2002-12-06','YYYY-MM-DD'),to_date('2013-06-15','YYYY-MM-DD'),'N','N');
INSERT INTO Rezerwacje VALUES( 3,'103',3,7,to_date('2001-11-04','YYYY-MM-DD'),to_date('2013-01-04','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 4,'104',3,3,to_date('2000-12-03','YYYY-MM-DD'),to_date('2013-12-23','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 5,'105',4,4,to_date('2001-01-02','YYYY-MM-DD'),to_date('2013-12-02','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 6,'106',4,4,to_date('2001-09-09','YYYY-MM-DD'),to_date('2013-09-11','YYYY-MM-DD'),'N','N');
INSERT INTO Rezerwacje VALUES( 7,'107',5,5,to_date('2001-10-10','YYYY-MM-DD'),to_date('2013-10-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 8,'201',6,6,to_date('2001-05-04','YYYY-MM-DD'),to_date('2013-06-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES( 9,'202',3,8,to_date('2001-08-23','YYYY-MM-DD'),to_date('2013-08-30','YYYY-MM-DD'),'Y','N');
INSERT INTO Rezerwacje VALUES(10,'203',3,3,to_date('2002-01-02','YYYY-MM-DD'),to_date('2013-02-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(11,'204',2,2,to_date('2002-02-02','YYYY-MM-DD'),to_date('2013-02-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(12,'205',2,9,to_date('2002-03-03','YYYY-MM-DD'),to_date('2013-03-23','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(13,'206',1,1,to_date('2002-03-04','YYYY-MM-DD'),to_date('2013-04-04','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(14,'207',1,9,to_date('2002-05-05','YYYY-MM-DD'),to_date('2013-05-20','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(15,'301',2,5,to_date('2002-06-06','YYYY-MM-DD'),to_date('2013-06-10','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(16,'302',2,2,to_date('2002-07-07','YYYY-MM-DD'),to_date('2013-07-09','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(17,'303',1,4,to_date('2002-08-08','YYYY-MM-DD'),to_date('2013-08-23','YYYY-MM-DD'),'Y','Y');
INSERT INTO Rezerwacje VALUES(18,'204',3,3,to_date('2002-09-09','YYYY-MM-DD'),to_date('2013-10-10','YYYY-MM-DD'),'Y','Y');
*/