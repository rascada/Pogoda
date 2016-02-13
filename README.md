# Pogoda
Strona stacji pogodowej w Skałągach

## Struktura
- `env/front.sh`: skrypt bashowy do kompilacji klienta.
- `src/SyntaxError/ApiBundle`: JSONowe API z [Symfony](https://symfony.com/)
- `src/SyntaxError/SocketBundle`: serwer web-socketów z [Ratchet](http://socketo.me/)

# Pogoda-cli
[![Dependency Status](https://david-dm.org/rascada/pogoda.svg?style=flat-square&path=src/Rascada/pogoda-cli)](https://david-dm.org/rascada/pogoda?path=src/Rascada/pogoda-cli) [![devDependency Status](https://david-dm.org/rascada/pogoda/dev-status.svg?style=flat-square&path=src/Rascada/pogoda-cli)](https://david-dm.org/rascada/pogoda?path=src/Rascada/pogoda-cli#info=devDependencies)
##### `src/Rascada/pogoda-cli`

Client for weather station api  
Written with [vue](http://vuejs.org)

## Setup
```sh
# go to pogoda-cli directory
~/Pogoda$ cd src/Rascada/pogoda-cli

~/Pogoda/src/Rascada/pogoda-cli$ npm i && bower i
```

## Build
```sh
~/Pogoda/src/Rascada/pogoda-cli$ npm run build
```

## Hacking
```sh
~/Pogoda/src/Rascada/pogoda-cli$ npm run dev
```
This command will run server which refresh pogoda-cli every time it detect change.
