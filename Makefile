# Makefile is notoriously obsessive with tabs, change it to be slightly more
# user friendly by using a ">" instead
.RECIPEPREFIX = >

update:
> yarn upgrade
> rsync -ah node_modules/bootstrap/dist/css/bootstrap.min.css themes/atvpc-bootstrap/
> rsync -ah node_modules/bootstrap/dist/js/bootstrap.min.js themes/atvpc-bootstrap/js/
> rsync -ah node_modules/jquery/dist/jquery.min.js themes/atvpc-bootstrap/js/
> rsync -ah node_modules/moment/min/moment.min.js themes/atvpc-bootstrap/js/
> rsync -ah node_modules/moment-timezone/builds/moment-timezone-with-data.min.js themes/atvpc-bootstrap/js/
> rsync -ah node_modules/typeface-oswald/files/* themes/atvpc-bootstrap/fonts/
> rsync -ah node_modules/font-awesome/css/font-awesome.min.css themes/atvpc-bootstrap/
> sed -i -e "s/url('..\//url('/g" themes/atvpc-bootstrap/font-awesome.min.css
> rsync -ah node_modules/font-awesome/fonts/* themes/atvpc-bootstrap/fonts/
> rm themes/atvpc-bootstrap/fonts/FontAwesome.otf

server:
> lsof -i -P -n | grep -q 'php.*LISTEN' || php -S '127.0.0.1:8000' &
> xdg-open 'http://127.0.0.1:8000'


#build: yarn
#> rm -r public/
#> hugo

#push: build
#> rsync -avz -e ssh --progress public/ timothy@keithieopia.com:/srv/http/keithieopia
