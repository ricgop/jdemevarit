-- odmazani existujicich tabulek, pokud existuji
drop table user_limitations;
drop table user_passwords;
drop table users;
drop table categories;

drop table Shlednuti;
drop table Hodnoceni;
drop table Prisady;
drop table categories;
drop table Recepty;


-- create db tables
create table users
(
	email varchar(40) NOT NULL,
	username varchar(40),
	active int(1) UNSIGNED, 
	PRIMARY KEY (email)
);

create table user_passwords
(
	email varchar(40) NOT NULL,
	password varchar(60),
	PRIMARY KEY (email),
	FOREIGN KEY (email) REFERENCES users(email)
);

create table categories
(
	category_id int UNSIGNED NOT NULL,
	category_name varchar(30) NOT NULL,
	PRIMARY KEY (category_id)
);

create table user_limitations
(
	email varchar(30) NOT NULL,
	category_id_1 int UNSIGNED NOT NULL,
	category_id_2 int UNSIGNED NOT NULL,
	category_id_3 int UNSIGNED NOT NULL,
	category_id_4 int UNSIGNED NOT NULL,
	category_id_5 int UNSIGNED NOT NULL,
	category_id_6 int UNSIGNED NOT NULL,
	FOREIGN KEY (email) REFERENCES users(email)
);

create table recipes
(
	Recept_ID int IDENTITY(1,1),
	Jmeno_Receptu varchar(50) NOT NULL,
	Email varchar(50),
	Datum_Pridani date NOT NULL,
	PRIMARY KEY (Recept_ID),
	FOREIGN KEY (Email) REFERENCES Uzivatele(Email)
);


create table Prisady
(
	Jmeno_Prisady varchar(50) NOT NULL,
	Recept_ID int,
	Mnozstvi varchar(20) NOT NULL,
	Popis varchar(50),
	PRIMARY KEY (Jmeno_Prisady, Recept_ID)
);


create table Hodnoceni
(
	Email_Hodnotitele varchar(50),
	Recept_ID int,
	Pocet_Bodu int NOT NULL,
	Popis varchar(500),
	PRIMARY KEY (Email_Hodnotitele,Recept_ID),
	FOREIGN KEY (Email_Hodnotitele) REFERENCES Uzivatele(Email),
	FOREIGN KEY (Recept_ID) REFERENCES Recepty(Recept_ID),
	CHECK (Pocet_Bodu>0 AND Pocet_Bodu <=5)
);


create table Shlednuti
(
	Shlednuti_ID int IDENTITY(1,1),
	Datum_Shlednuti date NOT NULL,
	Recept_ID int,
	Email varchar(50), -- pozor na to, jak je to provazany
	PRIMARY KEY (Shlednuti_ID),
	FOREIGN KEY (Recept_ID) REFERENCES Recepty(Recept_ID)
);