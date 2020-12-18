## Preferential Voting

Preferenciális szavazás, Condorced - Shulze kiértékeléssel
web oldal: https://github.com/utopszkij/prefvoting

## Licence: GPL

## Author
Fogler Tibor  tibor.fogler@gmail.com

https:// github.com/utopszkij

## Áttekintés
Többféle szavazás tipus támogatott: preferenciális, egy érték választható, több érték választható, Igen/nem.
A regisztrált tagok, csoport tagok szavazási kérdés javaslatokat vihetnek fel, és a kérdéshez megoldási javaslatokat (alternativákat) is megadhatnak.. Ezután - az Igen/Nem tipust kivéve -  három fázisból álló folyamat valósul meg:

1. támogatás gyüjtés ahhoz, hogy erről a kérdésről legyen-e szavazás?

2. alternativa javaslatok felvitele, és ezek támogatása,

3. szavazás 

Első fázisban az erre feljogosítottak egy "like" gombbal támogathatják, hogy legyen erről a kérdésről szavazás. Ha a kérdés elnyerte a kitüzött határidőre a kitüzött támogatottságot elindul a második fázis. 

A második fázisban megoldási alternativákat lehet a kérdéshez javasolni. Az erre feljogosított felhasználó egy "like" gombbal támogathatja, hogy az egyes alternativák felkerüljenek a szavazó képernyőre.

A beállított időpontban indul meg a harmadik fázis; a tényleges szavazás. A szavazó képernyőn azok az alternativák jelennek meg amelyek a második fázisban elérték a kitüzött támogatottságot.

Az Igen/nem tipusú szavazásoknál a második fázis kimarad.
## Tulajdonságok
- többféle szavazás tipus támogatása: preferenciális, egy érték választható, több érték választható, Igen/nem,
- tetszőleges számú szavazás,
- tetszőleges számú alternatíva,
- szavazás állapotok: támogatás gyüjtés, alternativa javaslat, szavazás, lezárt, megszakított, törölt,
- eredmény megjelenités kördigram, oszlop diagram, táblázat formájában,
- ** buddypress ** rendszerbe integrálható. A csoport oldal menübe beépül, itt lehet szavazást javasolni, támogatni, modosítani, alternativát javasolni, alternativát támogatni, szavazni, eredményt megnézni,
- definiálható jogosultságok; inditást támogathat, alternativát támogathat, szavazhat, alternativát javasolhat,: regisztráltak, csoport tagok, 
- esemény történet (javaslat, módosítás támogatás, alternativa javaslat, alternativa támogatás, inditás, lezárás, szavazás,
- nyilt és titkos szavazások támogatása (nyiltnál a konkrét szavazatok is lekérdezhetőek),
- a szavazást kezdeményező az első fázisban modosíthat a kérdésen és az Ő általa felvitt alternativákon,
- az alternativa javaslók a második fázisban addig modosíthatnak a sajátmaguk által felvitt alternatíván anig nem érkezik ahhoz "like",
- responsive dizajn, mobil barát,
- MVC struktúra,
- eseménykezelőkkel bővithető, shortkodokkal is aktivizálható,
- többnyelvüség előkészítve, magyar változatot tartalmaz,
- a megjelenés és müködés filterekkel, hurok esemény kezelőkkel testre szabható,
- Ha a "views" könyvtárban lévő fájloknak azonos nevü változata létezik az aktuális "theme" "prefvoting" könyvtárában akkor a plugin a téma könyvtárban lévőt használja.
## Szavazás nyilvántartás (prefvoting_votes tábla)
- ** id ** azonosító szám
- ** title ** megnevezés
- ** description ** leírás (html)
- ** gropup_id ** csoport
- ** creator_id ** létrehozó
- ** created_by ** létrehozás időpontja
- ** status ** státusz (proposal | add_alternative | send_voks | closed | cancelled | deleted)
- ** voks_type ** (pref | one_select | more_select | yes_no | yes_no_belong)
- ** status_comment ** státusz megjegyzés (pl. lezárás oka)
- ** deadline1 ** támogatási időszak vége
- ** min_like_count ** második fázishoz megkivánt támogatottság
- ** deadline2 ** alternativa javaslati időszak vége
- ** min_alt_like_count ** szavazó képernyőre kerüléshez megkivánt alternativa támogatottság
- ** deadlime3 ** szavazás vége
- ** can_view ** ki láthatja a szavazást (all | registered | member)
- ** can_voks ** ki szavazhat (registered | member)
- ** can_like ** ki támogathatja a szavazást (registered | member)
- ** can_add_alternative ** ki javasolhat alternatívát (registered | member |nobody)
- ** can_like_alternative ** ki támogathat alternativát (registered | member)
- ** can_get_result ** ki láthatja az eredményt (all | registered | memnber)
- ** sub_result ** szavazás közben részeredmény látható (I/N)
- ** secret ** titkos szavazás (I/N)
- ** valid ** érvényességi küszöb szám
- ** valid_type ** (abszolut szám vagy szavazásra jogosultak % -a)
- ** success ** eredményességi küszöb szám
- ** success_type ** (abszolut szám vagy szavazásra jogosultak % -a, vagy szavazatok %-a)
- ** result ** result cahce (új szavazat felvtel üriti)
### Kapcsolodó al-táblák
- ** prefvoting_likes ** [{id, vote_id, alt_id, user_id},....]
- ** prefvoting_alternatives ** alternativák [{id, vote_id, title, description, status, creator, created_by}, ...]
- ** prefvoting_vokses ** [{id, vote_id, alt_id, position, code, user_id}] 
## Szavazók nyilvántartása (prefvoting_voters tábla)
- ** id ** azonosító
- ** vote_id ** szavazás azonosító
- ** user_id ** szavazó user
- ** voks_time ** időpont 
## Plugin setup (prefvoting_setup tábla) 
- ** group_type ** csoportok kezelése ( budypress | other | none)
- ** min_like_count ** minimális elvárt szavazás támogatás (abszolut szám vagy szavazásra jogosultak %-a)
- ** min_alt_like_count ** minimális elvárt alternativa támogatás (abszolut szám vagy szavazásra jogosultak %-a)
## Esemény napló (prefvoting_log tábla)
- ** id ** azonosító
- ** vote_id ** szavazás azonosító
- ** alt_id ** alternativa azonosító
- ** action ** akció leírása
- ** action_by ** időpont
- ** user_id ** felhasználó azonosító
## Short kodok
- ** [prefvoting_lists group_id=xxx state=xxx] ** szavazás lista state:proposal | altproposal | voting | closed
- ** [prefvoting_create_vote group_id=xxxx] ** szavazás létrehozása képernyő
- ** [prefvoting_edit_vote vote_id=###] ** szavazás modosítása képernyő
- ** [prefvoting_vote_form vote_id=###] ** szavazás képernyő (státusztól függően különböző
- ** [prefvoting_result vote_id=###] ** szavazás eredménye
- ** [prefvoting]
## Globális funkciók
- ** prefvoting_list($attr) ** szavazás lista state:proposal | altproposal | voting | closed | deleted
- ** prefvoting_create_vote($attr) ** szavazás létrehozása képernyő
- ** prefvoting_edit_vote($attr) ** szavazás modosítása képernyő
- ** prefvoting_vote_form($attr) ** szavazás képernyő (státusztól függően különböző tartalom
- ** prefvoting_result($attr) ** szavazás eredménye
## Filterek
- ** prefvoting_create_form**
- ** prefvoting_edit_form **
- ** prefvoting_list_form **
- ** prefvoting_voting_form **
- ** prefvoting_thanks_voting_form **
- ** prefvoting_check_access ** jogosultság ellenörzés attr: ["id" => #, "action" => "xxx", "access" => bool]
- ** prefvoting_is_member ** bejelentkezett user csoport tag? attr: ["user_id" => #, "group_id" => #, "member" => bool]
- ** prefvoting_getgroups ** csoport lista attr: ["items" => array]
## Esemény kezelők (hoks)
- ** prefvoting_created($id) ** szavazás létrehozás
- ** prefvoting_edited($id) ** szavazás modosítás
- ** prefvoting_deleted($id) ** szavazás törlés
- ** prefvoting_liked($id) ** szavazás támogatása
- ** prefvoting_add_alternative($id, $al_id) ** alternativa javaslás
- ** prefvoting_alternative_liked($id, $alt_id) ** alternatíva támogatás
- ** prefvoting_start($id) ** szavazás inditás
- ** prefvoting_closed($id) ** szavazás lezárás
- ** prefvoting_get_result($id) ** eredmény képernyős
- ** prefvoting_voks_sended($id, $vokscode) ** szavazás
## SEO friend URL -ek
- ** /prefv/list-{group_id}-{state} **
- ** /prefv/create-{group_id} **
- ** /prefv/edit-{vote_id} **
- ** /prefv/form-{vote_id} **
- ** /prefv/result-{vote_id} **

** FIGYELEM! ** Az admin oldalon a beállítások/közvetlen hivakozások részél beállitani a "kategora" = prefv -t!

## Admin oldal
- szavazás böngésző, szürhető: szöveg részlet, csoport, állapot. Rendezés: cím, inditásdátuma, lezárás dtuma
- akciók: megnéz, szerkeszt, töröl, szavaz, eredmény, esemény napló, export, import
## Template rendszer
a képernyőn megjelenő tartalmakat a controller a 
```
$this->loadTemplate('templateName", ["paramName" => value, ....])
```
hívásokkal jeleniti meg. A "templateName" a "view" vagy {aktTheme}/prefvoting" könyvtárban lévő fájl neve (".php" nélkül).
A template  fájlok ".php" kitejesztésüek, de elsődleges tartalmuk HTML kód.
A következő speciális szintaxis elemeket is tartalmazhatják:

** {name} ** a loadTemplate hivás második paramétereként megadott tömb [name] elemét jeleníti meg,

** {{$name}}** a $name php változó értékét jeleniti meg (elsősorban cikus belsejében használandó)

** {_('token')} ** a __(token,PREFVOTING) nyelvi forditás eredményét jeleniti meg

** {if (php kód)} ** html kód ** {else} ** html kód ** {endif} ** if - else - endif feltételes rész

** {if (php kód)} ** html kód ** {endif} ** if - endif feltételes rész

** {foreach ($obj as $item)} ** html kód ..{{$item->name}} ....html kód... ** {endforeach} ** ciklus

** <?php php kód ?> **

## Telepítés a WP plugin telepítővel
- A https://github.com/utopszkij/prefvoting web helyről, a "code" gombra kattintva, majd a "Download zip" linket használva töltsd le a zip fájlt,  
- A Wordpress plugin telepítővel telepitsd ezt a zip fájlt 
- Plugin kezelőben kapcsold be a plugint.
## Kézi telepítés
- hozz létre a wp-conetent/plugin könyvtárba egy új prefvoting nevü könyvtárat
- ebbe másold be a repo tartalmát
- állitsd be a könyvtár és a fájlok tulajdonosát, jogosultságait, olyanra, hogy a web szerver/php irni, olvasni és törölni is tudja.
- A WP plugin kezelőben kapcsold be a plugint.
## Automatikus frissités
- kapcsold be a WP admin felületen, a plugin automatikus frissitési lehetőségét
## Kézi Frissítés
- A https://github.com/utopszkij/prefvoting web helyről, a "code" gomra kattintva, majd a "Download zip" linket használva töltsd le a zip fájlt, 
- A wordpress Plugin kezelőben kapcsold ki a plugint, majd távolisd el,
- Telepitsd újra  plugint (lásd fentebb),
    
 




