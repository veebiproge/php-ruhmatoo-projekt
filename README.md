# CDB


1. **Projekti veebirakenduse pilt:**
	* Veebirakenduse pilt
	* <img src = "bgImage.png">


1. **Liikmed:**
	* Oskar Nikopensius  
	* Rando Tomingas

	
1. **Eesmärk:**
	* Andmebaas kirikule...........
	
	
1. **Kirjeldus:**
	* Sihtrühm - Kirik 
	* Eripära...
	
	
1. **Funktsionaalsuse loetelu:**
	* Kasutaja loomine
	* Sisse logimine
	* Profiili kuva
	* Profiilis andmete muutmine
	* Kodugrupi/andide/tööharude/läbitud kursuste lisamine
	* Kõikide kasutajate kuvamine
	* Administreerimine
	
	
1. **Andmebaasi skeem + tabelite SQL laused:**
	* Skeem
		* Skeemi pilt

	* Laused
		 * CREATE TABLE `people` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `username` varchar(100) NOT NULL,
		 `password` varchar(128) NOT NULL,
		 `email` varchar(100) NOT NULL,
		 `firstname` varchar(50) NOT NULL,
		 `lastname` varchar(50) NOT NULL,
		 `phonenumber` varchar(25) DEFAULT NULL,
		 `date_of_birth` date NOT NULL,
		 `saved` date NOT NULL,
		 `baptised` date DEFAULT NULL,
		 `approved` int(11) DEFAULT '0',
		 `rights` int(11) DEFAULT '0',
		 PRIMARY KEY (`id`),
		 UNIQUE KEY `username` (`username`),
		 UNIQUE KEY `email` (`email`)
		 ) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=latin1
		 
		 * CREATE TABLE `courses` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `course` varchar(50) NOT NULL,
		 PRIMARY KEY (`id`),
		 UNIQUE KEY `course` (`course`)
		 ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1
		 
		 * CREATE TABLE `gifts` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `gift` varchar(50) NOT NULL,
		 PRIMARY KEY (`id`),
		 UNIQUE KEY `gift` (`gift`)
		 ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1
		 
		 * CREATE TABLE `giftsOnPpl` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `person` int(11) NOT NULL,
		 `gift` int(11) NOT NULL,
		 PRIMARY KEY (`id`),
		 KEY `person` (`person`),
		 KEY `giftsOnPpl_ibfk_2` (`gift`),
		 CONSTRAINT `giftsOnPpl_ibfk_1` FOREIGN KEY (`person`) REFERENCES `people` (`id`),
		 CONSTRAINT `giftsOnPpl_ibfk_2` FOREIGN KEY (`gift`) REFERENCES `gifts` (`id`)
		 ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1
		 
		 * CREATE TABLE `line_of_work` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `line_of_work` varchar(50) NOT NULL,
		 PRIMARY KEY (`id`),
		 UNIQUE KEY `line_of_work` (`line_of_work`)
		 ) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1
		 
		 * CREATE TABLE `l_o_wOnPpl` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `person` int(11) NOT NULL,
		 `line_of_work` int(11) NOT NULL DEFAULT '1',
		 PRIMARY KEY (`id`),
		 KEY `person` (`person`),
		 KEY `l_o_wOnPpl_ibfk_2` (`line_of_work`),
		 CONSTRAINT `l_o_wOnPpl_ibfk_1` FOREIGN KEY (`person`) REFERENCES `people` (`id`),
		 CONSTRAINT `l_o_wOnPpl_ibfk_2` FOREIGN KEY (`line_of_work`) REFERENCES `line_of_work` (`id`)
		 ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1
		 
		 * CREATE TABLE `pplInCourses` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `person` int(11) NOT NULL,
		 `course` int(11) NOT NULL,
		 PRIMARY KEY (`id`),
		 KEY `person` (`person`),
		 KEY `pplInCourses_ibfk_2` (`course`),
		 CONSTRAINT `pplInCourses_ibfk_1` FOREIGN KEY (`person`) REFERENCES `people` (`id`),
		 CONSTRAINT `pplInCourses_ibfk_2` FOREIGN KEY (`course`) REFERENCES `courses` (`id`)
		 ) ENGINE=InnoDB DEFAULT CHARSET=latin1
		 
		 * CREATE TABLE `pplInSmallgroups` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `person` int(11) NOT NULL,
		 `smallgroup` int(11) NOT NULL,
		 PRIMARY KEY (`id`),
		 KEY `smallgroup` (`smallgroup`),
		 KEY `person` (`person`),
		 CONSTRAINT `pplInSmallgroups_ibfk_1` FOREIGN KEY (`smallgroup`) REFERENCES `smallgroups` (`id`),
		 CONSTRAINT `pplInSmallgroups_ibfk_2` FOREIGN KEY (`person`) REFERENCES `people` (`id`)
		 ) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1
		 
		 * CREATE TABLE `smallgroups` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `name` varchar(50) NOT NULL,
		 `address` varchar(50) NOT NULL,
		 `leader` int(11) NOT NULL,
		 `meetingTime` varchar(100) DEFAULT NULL,
		 PRIMARY KEY (`id`),
		 UNIQUE KEY `name` (`name`),
		 KEY `leader` (`leader`),
		 CONSTRAINT `leader` FOREIGN KEY (`leader`) REFERENCES `people` (`id`)
		 ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1
		 
	
1. **Kokkuvõte:**
	* Rando 
		* Kokkuvõte
	* Oskar
		* Oskari kokkuvõte
	
	
	
	
'''''''
-----------------------------------


	
1. **Lehed:**
	* Log in
	* Sign up
	* Enda profiil
	* Administreerimine
	* Kodugrupi lisamine
	* Inimeste lisamine/kinnitamine
	* Andide/tööharude/läbitud kursuste lisamine
	* [logid]
	* [vaatamised]

	

	


## ISSUES:
	Login/Sign up -----------------> Oskar
		Leht
		Andmebaas
	Esileht -----------------> Oskar
		Enda info muutmise nupp
		Administreerimise nupp
		Enda profiili kuva
	Administreerimine
		Inimese lisamine -----------------> Oskar
			Kinnitamine
			Lisamine
		Kodugrupi lisamine -----------------> Rando
			Määrata
				id
				Nimi
				Juht
				Aadress
		Olemasoleva infot vaatamine/muutmine -----------------> Rando
			Info kuvamine
			Otsingud 
				Nime järgi - DONE
				Andide järgi
				Tööharude järgi
				Kodugruppide järgi
				Läbitud kursuste järgi
			Andide lisamine
				Tabel teha
				Funktsioon sisestamiseks
			Tööharude lisamine
				Tabel teha
				Funktsioon sisestamiseks
			Kursuste lisamine
				Tabel teha
				Funktsioon sisestamiseks
			Kodugruppi määramine
				Loetelust dropdownist määramine
				
Extras:


## Andmebaasid:
	people:
		id INT AUTO Primary
		username UNIQ
		password VARCHAR(128)
		email UNIQ
		firstname VARCHAR(50)
		lastname VARCHAR(50)
		phonenumber INT 
		date_of_birth DATE
		saved DATE
		baptised DATE
		aprroved INT (0- ei, 1 - ja 2 - kustutatud/arhiveeritud)
		rights INT 
	smallgroups:
		id INT AUTO Primary
		name VARCHAR(50)
		address VARCHAR(50)
		leader INT (viitab inimeste tabelis ID'le)
	gifts/line_of_work/courses:
		gift/line_of_work/course VARCHAR(50) Primary
	gifts/line_of_work/courses for people:
		id INT AUTO Primary
		person INT (viitab inimeste tabelis ID'le)
		gift/line_of_work/course VARCHAR(50)
		

	[Logid
		Tabel teha:
			id INT AUTO Primary
			inimene INT (viitab inimeste tabelis ID'le)
			muutust VARCHAR(20)
			ennem VARCHAR(50) enne muutust
			hiljem VARCHAR(50) peale muutust
		Funktsioon sisestamiseks]
		
		
	[Vaatamised
		Tabel teha:
			id INT AUTO Primary
			leht VARCHAR(50)
			kasutaja INT (viitab inimeste tabelis ID'le)
			millal DATETIME
		Funktsioon sisestamiseks]
		