# Pogoda
Strona stacji pogodowej w Skałągach

## Struktura
- `env/front.sh`: skrypt bashowy do kompilacji klienta.
- `src/Rascada`: źródła klienta
- `src/SyntaxError/ApiBundle`: źródła JSONowego API
- `src/SyntaxError/SocketBundle`: serwer web-socketów

## Kompilacja klienta:
```
jade ./src/Rascada/views/*.jade -o ./web
stylus ./src/Rascada/styl -o ./web/css
babel ./src/Rascada/script --out-dir ./web/js
```
