# Pogoda
Strona stacji pogodowej w Skałągach

## Struktura
- `env/front.sh`: skrypt bashowy do kompilacji klienta.
- `src/Rascada`: Pogoda-cli
- `src/SyntaxError/ApiBundle`: źródła JSONowego API z [Symfony](https://symfony.com/)
- `src/SyntaxError/SocketBundle`: serwer web-socketów z [Ratchet](http://socketo.me/)

# Pogoda-cli
Klient do api od stacji pogodowej  
Napisany jest z [vue](http://vuejs.org)

## Kompilacja
### [webpack](https://webpack.github.io/)
Pogoda-cli używa go do skompilowania aplikacji.
```sh
# aby go zainstalować należy
$ npm i -g webpack
```
### aby skompilować Pogode

```sh
# przejście do katalogu pogoda-cli
~/Pogoda$ cd src/Rascada
# zbudowanie pogody
~/Pogoda/src/Rascada$ npm run prod
```

## hakowanie pogody
```sh
~/Pogoda/src/Rascada$ npm run dev
```
To polecenie uruchomi serwer nasłuchujący na zmiany, który po ich wykryciu zbudje oraz odświeży stronę.
