# Pogoda
Strona stacji pogodowej w Skałągach

## Struktura
- `env/front.sh`: skrypt bashowy do kompilacji klienta.
- `src/Rascada`: źródła klienta
- `src/SyntaxError/ApiBundle`: źródła JSONowego API
- `src/SyntaxError/SocketBundle`: serwer web-socketów

## Kompilacja klienta:
### Kompilowanie z oficjalnymi cli
```
jade ./src/Rascada/views/jade/*.jade -o ./web
stylus ./src/Rascada/views/stylus -o ./web/css
babel ./src/Rascada/views/script --out-dir ./web/js
```

### Kompilacja z [front-render](https://github.com/rascada/front-render)
Rownież używa oficjalnych pluginów
```
~/Pogoda$ cd src/Rascada
~/Pogoda/src/Rascada$ front-render
```
