 echo "Init 2 "
 
docker exec keycloak sh /opt/keycloak/bin/kcadm.sh create users --realm=master -s username=eshop-admin -s enabled=true --server http://localhost:8080 -r eshop
echo "Priv setup"

docker exec keycloak sh /opt/keycloak/bin/kcadm.sh set-password --server http://localhost:8080 --realm master --username eshop-admin --new-password admin -r eshop

echo "Priv 2"
  
docker exec keycloak sh /opt/keycloak/bin/kcadm.sh add-roles --server http://localhost:8080 --realm eshop --type users --users eshop-admin --roles admin


docker exec keycloak sh /opt/keycloak/bin/kcadm.sh create clients -r "$REALM_NAME" -s clientId="$CLIENT_ID" -s redirectUris="$REDIRECT_URIS" -s protocol=openid-connect -s standardFlowEnabled=true -s implicitFlowEnabled=false -s directAccessGrantsEnabled=true -s serviceAccountsEnabled=true -s authorizationServicesEnabled=true -s directGrantsOnly=false -s fullScopeAllowed=true -s webOrigins=["*"] -s responseTypes=[$RESPONSE_TYPE] -s defaultClientScopes=[$SCOPE] --server "$KEYCLOAK_URL" --realm master

docker exec keycloak sh /opt/keycloak/bin/kcadm.sh create clients -r eshop -s "clientId=userHandling" -s "directAccessGrantsEnabled=true" -s "publicClient=false"

frontend:
    image: httpd:2.4
    container_name: frontend
    restart: always
    ports:
      - "8000:80"
    volumes:
      - /home/petekape/Desktop/projects/Eshop/eShop/frontend/src:/usr/local/apache2/htdocs/
