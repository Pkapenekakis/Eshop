#!/bin/bash
set -e


KEYCLOAK_URL="http://localhost:8080"
REALM_NAME="eshop"
ADMIN_USER="admin"
ADMIN_PASSWORD="admin"


/usr/local/bin/wait-for-it.sh keycloak:8080 -t 0 -- echo "Keycloak is up."

			
docker exec keycloak sh /opt/keycloak/bin/kcadm.sh create realms -s realm="$REALM_NAME" -s enabled=true -s loginTheme=keycloak -s accountTheme=keycloak.v2 -s registrationAllowed=true -o --server "$KEYCLOAK_URL" --realm master --user "$ADMIN_USER" --password "$ADMIN_PASSWORD"

docker exec keycloak sh /opt/keycloak/bin/kcadm.sh config credentials --server "$KEYCLOAK_URL" --realm master --user "$ADMIN_USER" --password "$ADMIN_PASSWORD"

docker exec keycloak sh /opt/keycloak/bin/kcadm.sh create clients -r eshop -s clientId=userHandling -s "publicClient=true" -s 'attributes."client.authentication"=true' -s 'attributes."authorization"=true' -s 'directAccessGrantsEnabled=true' -s 'attributes."backchannel.logout.session.required"=true' -s 'webOrigins=["*"]' -s 'attributes."backchannel.logout.url"=http://localhost:8000' -s 'attributes."home.Url"=[http://localhost:8000/index.html]' -s 'redirectUris=["http://localhost:8000/*"]' -i

echo -e "\nClient and realm creation is complete"

exec "$@"
