# CDB

1. Sihtrühm:
	Kirik
1. Lehed:
	Log in/Sign up
	Enda profiil
	Administreerimine
	Kodugrupi lisamine
	Inimeste lisamine/kinnitamine
	Andide/tööharude/läbitud kursuste lisamine
	[logid]
	[vaatamised]

1. Liikmed:
	Oskar Nikopensius, 
	Rando Tomingas

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
		phonenumber INT ----------------------------- TO-DO
		date_of_birth DATE
		saved DATE
		baptised DATE
		aprroved INT (0- ei, 1 - ja 2 - kustutatud/arhiveeritud)
		rights -------------------------- TO-DO
	smallgroups:
		id INT AUTO Primary
		name VARCHAR(50)
		address VARCHAR(50)
		leader INT (viitab inimeste tabelis ID'le)
	gifts/line_of_work/courses:
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
		