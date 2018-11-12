Pozdrav, posto mnogo ljudi trazi po internetu kako da uradi grafikon igraca na vasem serveru, a to nigdje nema, odlucio sam napraviti i objaviti skriptu. U skripti ima jos nesto osim grafikona, ali redom cemo ici.

1) Graficon

Uopsteno: Grafikon uzima broj igraca sa GameTracker.rs api, ali ako imate svoju skriptu da skenira server podatke mozete lako to promijeniti da ide sa vasim podatcima...

Evo mozete pogledati slike:
http://prntscr.com/42id9i
http://banners.gametracker.rs/176.57.128.40:27056/graph-day/graph-day.jpg

Znaci ako hocete da napravim da ovaj grafik bude i u baneru kao na gt http://banners.gametracker.rs/176.57.128.40:27056/big/red/banner.jpg?1405331194 ovako pisite mi pa cu ja viditi ako budete htjeli napravicu i to tako ..

2) Napravio sam ovde i da se moze na Geo mapi pogledati gdje je hostovan server

http://prntscr.com/42idsq

3) Imate ovde jos i da se prikaze slika mape koja je trenutno na serveru. Ali ja nisam dodavao slike ako neko bude to htio u maps folder dodajete slike znaci ime slike mora da bude kao ime mape to je vazno a sto se ekstenzije tice napravio sam da moze png i jpg ali i to mozete promijeniti u includes.php
[CODE]GTApi::$GetCurrentMapImage['extensijezaslikumape'] = array('jpg', 'png');[/CODE]
samo tu u array dodajte u nastavku jos ekstenzije koje hocete .. A ako nemate te mape koja je na serveru u maps folderu onda dodate i jednu sliku koja ce izaci ako mape nema tu sliku isto dodajte u maps folder i u includes.php
[CODE]GTApi::$GetCurrentMapImage['slikazaucitavanjeakonemamape'] = 'maps/nomap.jpg';[/CODE]
Samo ovde dodate putanju do slike ..

Da objasnim jos kako ovo da pozovete gdje upisete ip svog servera ...

1) IP svog servera pisete u includes.php fajlu

[CODE]$gtapi = new GTApi('176.57.128.40', '27056');[/CODE] 
Znaci ovde umesto 176.57.128.40 upisite vas ip a umesto 27056 vas port

2) Da biste ispisali grafikon vaseg servera u index.php dodajte:
[CODE]$gtapi->GTBigGraficonPlayer();[/CODE]

2) Da biste ispisali Geo mapu gdje je hostovan vas server u index.php dodajte:
[CODE]echo $gtapi->GetServerHostedMap();[/CODE]

3) Da biste ispisali sliku mape koja je na vasem serveru u index.php dodajte:
[CODE]echo $gtapi->GetCurrentMapImage();[/CODE]