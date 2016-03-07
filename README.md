# repo oficjalnie zamknięte!
zostało odpowiednio podzielone na 2 osobne:
- [pogoda-api](https://github.com/skalagi/pogoda-api)
- [pogoda-cli](https://github.com/skalagi/pogoda-cli)

# Pogoda
Strona stacji pogodowej w Skałągach

## Struktura
- `env/front.sh`: skrypt bashowy do kompilacji klienta.
- `src/SyntaxError/ApiBundle`: JSONowe API z [Symfony](https://symfony.com/)
- `src/SyntaxError/SocketBundle`: serwer web-socketów z [Ratchet](http://socketo.me/)

# Pogoda-cli
[![Dependency Status](https://david-dm.org/rascada/pogoda.svg?style=flat-square&path=src/Rascada/pogoda-cli)](https://david-dm.org/rascada/pogoda?path=src/Rascada/pogoda-cli) [![devDependency Status](https://david-dm.org/rascada/pogoda/dev-status.svg?style=flat-square&path=src/Rascada/pogoda-cli)](https://david-dm.org/rascada/pogoda?path=src/Rascada/pogoda-cli#info=devDependencies)
##### `src/Rascada/pogoda-cli`

Klient do api od stacji pogodowej  
Napisany jest z [vue](http://vuejs.org)

## Kompilacja
Aby skompilować pogodę należy wpisać `npm run build` w katalogu pogoda-cli

```sh
# przejście do katalogu pogoda-cli
~/Pogoda$ cd src/Rascada/pogoda-cli
# zbudowanie pogody
~/Pogoda/src/Rascada/pogoda-cli$ npm run build
```

## hakowanie pogody
```sh
~/Pogoda/src/Rascada/pogoda-cli$ npm run dev
```
To polecenie uruchomi serwer nasłuchujący na zmiany, który po ich wykryciu zbudje oraz odświeży stronę.
