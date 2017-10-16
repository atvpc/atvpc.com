# Makefile is notoriously obsessive with tabs, change it to be slightly more
# user friendly by using a ">" instead
.RECIPEPREFIX = >

server
> php -S 127.0.0.1:8000 &
> sleep 5s && xdg-open "http://127.0.0.1:8000"
