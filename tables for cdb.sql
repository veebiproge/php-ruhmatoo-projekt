CREATE TABLE people(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(100) UNIQUE,
	password VARCHAR(128) NOT NULL,
	email VARCHAR(100) UNIQUE NOT NULL,
	firstname VARCHAR(50) NOT NULL,
	lastname VARCHAR(50) NOT NULL,
	phonenumber INT,
	date_of_birth DATE NOT NULL,
	saved DATE DEFAULT NULL,
	baptised DATE DEFAULT NULL,
	approve INT NOT NULL DEFAULT 0,
	rights INT NOT NULL DEFAULT 0
);

CREATE TABLE smallgroups(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(50) NOT NULL UNIQUE,
	address VARCHAR(50),
	leader INT NOT NULL,
	meetingTime VARCHAR(100),
	FOREIGN KEY (leader) REFERENCES people(id)
);

CREATE TABLE pplInSmallgroups(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	person INT NOT NULL,
	smallgroup INT NOT NULL,
	FOREIGN KEY (smallgroup) REFERENCES smallgroups(id),
	FOREIGN KEY (person) REFERENCES people(id)
);

CREATE TABLE gifts(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	gift VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE giftsOnPpl(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	person INT NOT NULL,
	gift INT NOT NULL,
	FOREIGN KEY (gift) REFERENCES gifts(id),
	FOREIGN KEY (person) REFERENCES people(id)
);

CREATE TABLE line_of_work(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	line_of_work VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE l_o_wOnPpl(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	person INT NOT NULL,
	line_of_work INT NOT NULL,
	FOREIGN KEY (line_of_work) REFERENCES line_of_work(id),
	FOREIGN KEY (person) REFERENCES people(id)
);

CREATE TABLE courses(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	course VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE pplInCourses(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	person INT NOT NULL,
	course INT NOT NULL,
	FOREIGN KEY (course) REFERENCES courses(id),
	FOREIGN KEY (person) REFERENCES people(id)
);

CREATE TABLE logs(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	field_of_change VARCHAR(100) NOT NULL,
	value_before VARCHAR(100),
	value_after VARCHAR(100)	
);