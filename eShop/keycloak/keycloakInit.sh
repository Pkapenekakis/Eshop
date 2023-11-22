#!/bin/bash
set -e

#while ! command -v wget; do
#    echo "Waiting for utilities to install..."
#    sleep 2
#done
	
/usr/local/bin/wait-for-it.sh keycloak:8080 -t 0 -- echo "Keycloak is up."

			
docker exec keycloak sh /opt/keycloak/bin/kcadm.sh create realms -s realm="eshop" -s enabled=true -o --server http://localhost:8080 --realm master --user admin --password admin

KEYCLOAK_URL="http://localhost:8080/auth"
REALM_NAME="eshop"
ADMIN_USER="admin"
ADMIN_PASSWORD="admin"

# Create a new client
CLIENT_ID="userHandling"
REDIRECT_URIS="http://localhost:8080/*" # Add your redirect URIs
RESPONSE_TYPE="code"
SCOPE="openid"

kcadm.sh config credentials --server "$KEYCLOAK_URL" --realm master --user "$ADMIN_USER" --password "$ADMIN_PASSWORD"

kcadm.sh create clients -r "$REALM_NAME" -s clientId="$CLIENT_ID" -s redirectUris="$REDIRECT_URIS" -s protocol=openid-connect \
  -s publicClient=true -s standardFlowEnabled=true -s implicitFlowEnabled=false -s directAccessGrantsEnabled=true \
  -s serviceAccountsEnabled=true -s authorizationServicesEnabled=true -s directGrantsOnly=false -s fullScopeAllowed=true \
  -s webOrigins=["*"] -s responseTypes=[$RESPONSE_TYPE] -s defaultClientScopes=[$SCOPE]

exec "$@"
