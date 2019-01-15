YARN := $(shell command -v yarn 2>/dev/null)

update:
ifndef YARN
	$(error "yarn is not installed")
endif
	yarn upgrade
	rsync -ah node_modules/bootstrap/dist/css/bootstrap.min.css themes/atvpc-bootstrap/css/
	rsync -ah node_modules/bootstrap/dist/js/bootstrap.min.js themes/atvpc-bootstrap/js/
	rsync -ah node_modules/bootstrap-drawer/dist/css/bootstrap-drawer.min.css themes/atvpc-bootstrap/css/
	rsync -ah node_modules/bootstrap-drawer/dist/js/drawer.min.js themes/atvpc-bootstrap/js/
	rsync -ah node_modules/jquery/dist/jquery.min.js themes/atvpc-bootstrap/js/
	rsync -ah node_modules/typeface-oswald/files/* themes/atvpc-bootstrap/fonts/

build:
	node_modules/clean-css-cli/bin/cleancss -o themes/atvpc-bootstrap/css/style.min.css themes/atvpc-bootstrap/css/style.css
	sed -i -e "s/style.css/style.min.css/g" themes/atvpc-bootstrap/index.twig

serve: build
	lsof -i -P -n | grep -q 'php.*LISTEN' || php -S '127.0.0.1:8000' &
	xdg-open 'http://127.0.0.1:8000'

push:
	git push
	rsync -avz -e ssh --exclude=.git --exclude=node_modules --progress --no-perms --no-owner --no-group --no-times . www.atvpc.com:/srv/htdocs/atvpc.com
