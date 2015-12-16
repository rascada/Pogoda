# Pogoda
Strona stacji pogodowej w Skałągach

## Struktura
- `env/front.sh`: skrypt bashowy do kompilacji klienta.
- `src/Rascada`: źródła klienta
- `src/SyntaxError/ApiBundle`: źródła JSONowego API
- `src/SyntaxError/SocketBundle`: serwer web-socketów

## Kompilacja klienta:
#### [webpack](https://webpack.github.io/)
Klient pogody używa go do skompilowania aplikacji.
```sh
# aby go zainstalować należy
$ npm i -g webpack
```
#### aby skompilować Pogode

```sh
~/Pogoda$ cd src/Rascada
~/Pogoda/src/Rascada$ webpack
# albo
~/Pogoda$ webpack src/Rascada
```
