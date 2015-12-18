# Pogoda
Strona stacji pogodowej w Skałągach

## Struktura
- `env/front.sh`: skrypt bashowy do kompilacji klienta.
- `src/Rascada`: źródła klienta
- `src/SyntaxError/ApiBundle`: źródła JSONowego API
- `src/SyntaxError/SocketBundle`: serwer web-socketów

# Pogoda-cli

## kompilacja:
#### [webpack](https://webpack.github.io/)
Pogoda-cli używa go do skompilowania aplikacji.
```sh
# aby go zainstalować należy
$ npm i -g webpack
```
#### aby skompilować Pogode

```sh
# przejście do katalogu pogoda-cli
~/Pogoda$ cd src/Rascada
# inicializacja webpack'a
~/Pogoda/src/Rascada$ webpack
```
