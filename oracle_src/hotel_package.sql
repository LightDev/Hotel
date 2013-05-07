create or replace 
PACKAGE hotel as
        PROCEDURE addUser(imie VARCHAR2, nazwisko VARCHAR2, login VARCHAR2,haslo VARCHAR2, nr_karty CHAR);
END hotel;

create or replace 
PACKAGE BODY hotel is
    PROCEDURE addUser(imie VARCHAR2, nazwisko VARCHAR2, login VARCHAR2,haslo VARCHAR2, nr_karty CHAR) AS
    max_id NUMBER :=0;
    BEGIN
    SELECT max(id) INTO max_id FROM goscie;
    max_id:=max_id+1;
      INSERT INTO GOSCIE(id,imie,nazwisko,login,haslo,karta_kredytowa) VALUES(max_id,imie,nazwisko,login,haslo,nr_karty);
    END addUser;
  END hotel;
	