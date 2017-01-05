# CDB


1. **Projekti veebirakenduse pilt?**
	* ??


1. **Liikmed:**
	* Oskar Nikopensius  
	* Rando Tomingas

	
1. **Eesmärk:**
	* Andmebaas kirikule...........
	
	
1. **Kirjeldus:**
	* Sihtrühm - Kirik 
	* Eripära
	
	
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

	* Laused
	
	
1. **Kokkuvõte:**
	* Rando 
		* Kokkuvõte
	* Oskar
		* Oskari kokkuvõte
	
	
	
	
'''''''
-----------------------------------
'''''''

	
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
		