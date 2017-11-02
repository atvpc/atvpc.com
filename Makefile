# Makefile is notoriously obsessive with tabs, change it to be slightly more
# user friendly by using a ">" instead
.RECIPEPREFIX = >

update:
> yarn upgrade
> rsync -avh node_modules/bootstrap/dist/css/bootstrap.min.css themes/atvpc-bootstrap/
> rsync -avh node_modules/bootstrap/dist/js/bootstrap.min.js themes/atvpc-bootstrap/js/
> rsync -avh node_modules/jquery/dist/jquery.min.js themes/atvpc-bootstrap/js/
> rsync -avh node_modules/moment/min/moment.min.js themes/atvpc-bootstrap/js/
> rsync -avh node_modules/moment-timezone/builds/moment-timezone-with-data.min.js themes/atvpc-bootstrap/js/
> rsync -avh node_modules/typeface-flavors/files/* themes/atvpc-bootstrap/fonts/
> rsync -avh node_modules/font-awesome/css/font-awesome.min.css themes/atvpc-bootstrap/
> sed -i -e "s/url('..\//url('/g" themes/atvpc-bootstrap/font-awesome.min.css
> rsync -avh node_modules/font-awesome/fonts/* themes/atvpc-bootstrap/fonts/

server: update
> php -S 127.0.0.1:8000 &
> sleep 5s && xdg-open "http://127.0.0.1:8000"

#build: yarn
#> rm -r public/
#> hugo

#push: build
#> rsync -avz -e ssh --progress public/ timothy@keithieopia.com:/srv/http/keithieopia
