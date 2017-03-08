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
	limitation_1 int UNSIGNED,
	limitation_2 int UNSIGNED,
	limitation_3 int UNSIGNED,
	limitation_4 int UNSIGNED,
	limitation_5 int UNSIGNED,
	limitation_6 int UNSIGNED,
	PRIMARY KEY (email),
	FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE
);

create table recipes
(
	recipe_id int NOT NULL AUTO_INCREMENT,
	email varchar(30) NOT NULL,
	PRIMARY KEY (recipe_id),
	FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE
);

create table recipe_limitations
(
	recipe_id int NOT NULL AUTO_INCREMENT,
	limitation_1 int UNSIGNED,
	limitation_2 int UNSIGNED,
	limitation_3 int UNSIGNED,
	limitation_4 int UNSIGNED,
	limitation_5 int UNSIGNED,
	limitation_6 int UNSIGNED,
	PRIMARY KEY (recipe_id),
	FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
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

create table recipe_photo
(
	recipe_id int NOT NULL AUTO_INCREMENT,
	file_name varchar(3000),
	PRIMARY KEY (recipe_id),
	FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
);

-- admin part
create table admins
(
	email varchar(40) NOT NULL,
	username varchar(40),
	active int(1) UNSIGNED, 
	PRIMARY KEY (email,username)
);

create table admin_passwords
(
	email varchar(40) NOT NULL,
	password varchar(60),
	PRIMARY KEY (email),
	FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE
);




-- create views
CREATE OR REPLACE VIEW recipe_thumbnails AS
SELECT r.recipe_id, r.email, rn.recipe_name, u.username, rp.file_name from recipes r
JOIN recipe_name rn ON r.recipe_id = rn.recipe_id
JOIN users u ON r.email = u.email
JOIN recipe_photo rp ON r.recipe_id = rp.recipe_id;

CREATE OR REPLACE VIEW recipe_details AS
SELECT r.recipe_id, r.email, rn.recipe_name, rc.recipe_content, rpro.recipe_process, u.username, rp.file_name,
rl.limitation_1, rl.limitation_2, rl.limitation_3, rl.limitation_4, rl.limitation_5, rl.limitation_6 
from recipes r
JOIN recipe_name rn ON r.recipe_id = rn.recipe_id
JOIN users u ON r.email = u.email
JOIN recipe_photo rp ON r.recipe_id = rp.recipe_id
JOIN recipe_content rc ON r.recipe_id = rc.recipe_id
JOIN recipe_process rpro ON r.recipe_id = rpro.recipe_id
JOIN recipe_limitations rl ON r.recipe_id = rl.recipe_id;

/*
create table recipe_score
(
	recipe_id int NOT NULL AUTO_INCREMENT,
	votes
	score int,
	PRIMARY KEY (recipe_id),
	FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
);*/