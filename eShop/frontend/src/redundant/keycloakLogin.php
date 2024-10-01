<?php
  //keycloak JavaScript Adapter and initialization code
  <script src="https://cdn.keycloak.org/10.0.2/keycloak.js"></script>

  <script>
  const keycloak = Keycloak({
    url: 'http://localhost:8080/auth',
    realm: 'eshop',
    clientId: 'userHandling'
  });

  keycloak.init({ onLoad: 'login-required' }).then((authenticated) => {
    if (authenticated) {
      // User is authenticated, proceed with your application logic
    }
  });
</script>

  
  // Check if Keycloak session exists, if not, trigger Keycloak login
  if (!isset($_COOKIE['KEYCLOAK_SESSION'])) {
    echo "<script>keycloak.login();</script>";
    exit();
  }
?>
