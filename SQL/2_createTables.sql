-- create db tables
create table users
(
	email varchar(40) NOT NULL,
	username varchar(40),
	active int(1) UNSIGNED, 
	PRIMARY KEY (email,username)
);

create table user_passwords
(
	email varchar(40) NOT NULL,
	password varchar(60),
	PRIMARY KEY (email),
	FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE
);

create table user_phones
(
	email varchar(40) NOT NULL,
	phone varchar(60),
	PRIMARY KEY (email),
	FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE
);

create table limitations
(
	limitation_id int UNSIGNED NOT NULL AUTO_INCREMENT,
	limitation_name varchar(30) NOT NULL,
	PRIMARY KEY (limitation_id)
);

create table user_limitations
(
	email varchar(30) NOT NULL,
	category_id int UNSIGNED NOT NULL,
	PRIMARY KEY (email, category_id),
	FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE,
	FOREIGN KEY (limitation_id) REFERENCES limitations(limitation_id) ON DELETE CASCADE
);

create table recipes
(
	recipe_id int NOT NULL AUTO_INCREMENT,
	email varchar(30) NOT NULL,
	date_added date NOT NULL,
	PRIMARY KEY (recipe_id),
	FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE
);

create table recipe_limitations
(
	recipe_id int NOT NULL AUTO_INCREMENT,
	limitation_id int UNSIGNED NOT NULL,
	PRIMARY KEY (recipe_id, limitation_id),
	FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE,
	FOREIGN KEY (limitation_id) REFERENCES limitations(limitation_id) ON DELETE CASCADE
);

create table recipe_name
(
	recipe_id int NOT NULL AUTO_INCREMENT,
	recipe_name varchar(40),
	PRIMARY KEY (recipe_id),
	FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
);

create table recipe_content
(
	recipe_id int NOT NULL AUTO_INCREMENT,
	recipe_content varchar(200),
	PRIMARY KEY (recipe_id),
	FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
);

create table recipe_process
(
	recipe_id int NOT NULL AUTO_INCREMENT,
	recipe_process varchar(3000),
	PRIMARY KEY (recipe_id),
	FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
);

create table recipe_process
(
	recipe_id int NOT NULL AUTO_INCREMENT,
	recipe_process varchar(3000),
	PRIMARY KEY (recipe_id),
	FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
);