# CDB

1. Sihtrühm:
	Kirik
1. Lehed:
	Login/Sign up
	Enda profiil
	Administreerimine
	Kodugrupi lisamine
	Inimeste lisamine/kinnitamine
	Andide/tööharude/läbitud kursuste lisamine
	[logid]
	[vaatamised]

1. Liikmed:
	Oskar Nikopensius
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
				Nime järgi
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
	Inimesed:
		id INT AUTO Primary
		kasutajanimi UNIQ
		pw(hash) VARCHAR(128)
		email UNIQ
		eesnimi VARCHAR(50)
		perenimi VARCHAR(50)
		sünnikuupäev DATE
		päästetud DATE
		ristitud DATE
		aprroved INT (0- ei, 1 - ja 2 - kustutatud/arhiveeritud)
	Kodugrupid:
		id INT AUTO Primary
		nimi VARCHAR(50)
		aadress VARCHAR(50)
		juht INT (viitab inimeste tabelis ID'le)
	Annid/Tööharud/kursused:
		id INT AUTO Primary
		inimene INT (viitab inimeste tabelis ID'le)
		and/tööharu/kursus VARCHAR(50)
		
	


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
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
/*
AmazonCheap
Näidata, millise riigi amazoni saidil on kaup kõige odavam
Sihtrühm:
	Vanus: 20-55
	Sugu: Mehed, Naised
	Sots./Maj. staatus: palk->500+ Haridus->Kesk või parem
	Muu: Arvuti kodus olemas, interneti makse võimalus
	
Lehed:
	1) Valib riigi, valuuta, sisestab otsingu
	2) Otsingu tulemused, järjestatud hinna järgi
		Võimalus lisada lemmikutesse, eeldab kasutaja tegemist.
		
		
Liikmed:
	Oskar Nikopensius
	Rando Tomingas
	*/