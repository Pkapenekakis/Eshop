#!/bin/bash
set -e

#while ! command -v wget; do
#    echo "Waiting for utilities to install..."
#    sleep 2
#done
	
/usr/local/bin/wait-for-it.sh keycloak:8080 -t 0 -- echo "Keycloak is up."


echo "test"					
docker exec keycloak sh /opt/keycloak/bin/kcadm.sh create realms -s realm="eshop" -s enabled=true -o --server http://localhost:8080 --realm master --user admin --password admin

exec "$@"
