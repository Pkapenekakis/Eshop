#!/bin/bash
set -e


KEYCLOAK_URL="http://localhost:8080"
REALM_NAME="eshop"
ADMIN_USER="admin"
ADMIN_PASSWORD="admin"

# Create a new client
REDIRECT_URIS="http://localhost:8000/index.php" # Add your redirect URIs
RESPONSE_TYPE="code"
SCOPE="openid"


/usr/local/bin/wait-for-it.sh keycloak:8080 -t 0 -- echo "Keycloak is up."

			
docker exec keycloak sh /opt/keycloak/bin/kcadm.sh create realms -s realm="$REALM_NAME" -s enabled=true -o --server "$KEYCLOAK_URL" --realm master --user "$ADMIN_USER" --password "$ADMIN_PASSWORD"

docker exec keycloak sh /opt/keycloak/bin/kcadm.sh config credentials --server "$KEYCLOAK_URL" --realm master --user "$ADMIN_USER" --password "$ADMIN_PASSWORD"

docker exec keycloak sh /opt/keycloak/bin/kcadm.sh create clients -r eshop -s "clientId=userHandling" -s "directAccessGrantsEnabled=true" -s "publicClient=false"

echo -e "\nClient and realm creation is complete"

exec "$@"
