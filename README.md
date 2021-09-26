# SpeedTestMap - mapa testów SpeedTest

__SpeedTestMap__ - jest aplikacją WWW do zaznaczania wyników testów przepustowości połączenia z internetem na mapie. W tym celu
wykorzystano takie technologie jak OpenStreetMap, Leaflet.js czy Bootstrap 4. 

__Wymagania__:

* LAMP Stack = Linux Apache MySQL (MariaDB) PHP >= 7.0

__Instalacja__:

1. git clone https://github.com/xf0r3m/speedtestmap.git
2. sudo cp speedtestmap/* /var/www/html
3. chown -R www-data:www-data /var/www/html
4. chmod -R 775 /var/www/html
5. sudo mysql < /var/www/html/install.sql
6. Przedchodzimy do przeglądarki, wpisujemy adres, na którym hostujemy SpeedTestMap.
W prawym górnym rogu, kilkamy "Zaloguj się" dokonujemy rejestracji naszego użytkownika. 

__Użytkowanie__:

Pierwszą rzeczą jaką należy zrobić jest, zdefiniowanie znaczników mapy. Wybranie ich nazwy 
oraz koloru. Następnie możemy przejść dodania wyników testu. Możemy zrobić do na dwa sposoby.
Automatyczny oraz ręczy. W ręczny sposób, to po prostu wypełniamy wszystkie pola po kolei. 
Z kolei w trybie automatycznym musimy przygotować, plik .CSV według poniżeszego formatu:

```
id_znacznika,data_testu,typ_polaczenia,szerokosc_geograficzna,dlugosc_geograficzna,predkość_pobierania,prędkosć_wysyłania,wartość_opóźnienia
```

__Uwagi__:

Z racji tego iż, dane GPS mogą być nie dokładne, dlatego niektóre znacznikia mogą na siebie zachodzić. Dlatego dopisuje się losową liczbe z przedziału 210 - 900 włączenie do danych gps, aby odsunąć trochę od siebie znaczniki. Można tego uniknąć, dokonując testów prędkości z włączonym modułem lokalizacji w naszym urządzeniu. Może być tak że markery nie wskazują  w ogóle rzeczywistej lokalizaji testu, oznacza to iż aplikacja nie mogłą wydobyć danych lokalizacyjnych z urządzenia.
