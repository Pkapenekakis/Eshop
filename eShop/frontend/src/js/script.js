function toRegister() {
    window.location = '/signup.html';
}

function backToHome(){
    window.location = '/index.html';
}

function toWelcome(){
    window.location = '/welcome.html';
}

function toCart(){
    window.location = '/cart.php';
}

function toAddProduct(){
    window.location = '/addProduct.php';
}

function toSeller(){
    window.location = '/seller.php';
}

function toAdmin(){
    window.location = '/administration.php';
}

function decodeJwt(jwtToken) {
  const base64Url = jwtToken.split('.')[1]; // Get the payload part of the JWT
  const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/'); // Replace Base64 URL encoding characters
  const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
  }).join('')); // Decode Base64 and handle URI component encoding

  return JSON.parse(jsonPayload);
}

async function Register(e) {

    e.preventDefault();
      try {
        // Get user input
        const getUsername = document.getElementById("reg-username").value;
        const getEmail = document.getElementById("reg-email").value;
        const getPassword = document.getElementById("reg-password").value;
        const getRole = document.getElementById("role").value;

        // Get admin access token
        const adminAccessTokenResponse = await fetch("http://localhost:8080/realms/master/protocol/openid-connect/token", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
            'grant_type': 'client_credentials',
            'client_id': 'admin-cli',
            'client_secret': 'fQq9c5FSlngbc6bxqv3m5dSyPzXruj8L',
          }),
        });

        if (!adminAccessTokenResponse.ok) {
          const err = await adminAccessTokenResponse.json();
          console.log(err);
          return;
        }

        const adminAccessToken = await adminAccessTokenResponse.json();
        const token = adminAccessToken.access_token;

        // Register user
        const registerResponse = await fetch("http://localhost:8080/admin/realms/eshop/users", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token,
          },
          body: JSON.stringify({
            'email': getEmail,
            'enabled': true,
            'username': getUsername,
            'attributes': {
              'client_id': 'userHandling',
            },
            //'groups': ['/Customer'],
            'credentials': [
              {
                'type': 'password',
                'value': getPassword,
                'temporary': false,
              },
            ],
          }),
        });

        if (registerResponse.ok) {
          alert('User registration successful');
          setTimeout(() => {
            window.location.href = "http://localhost:8000/index.html";
          }, 2000);
        } else {
          const err = await registerResponse.json();
          console.log(err);
        }
      } catch (error) {
        console.log(error);
      }

      return false;
}

async function Login(e){
  //prevent reload page onsubmit
  e.preventDefault()
  //get user username
  const getUsernameLogin = document.getElementById("username").value;
  //get user password
  const getPasswordLogin = document.getElementById("password").value;

  try {
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

    var urlencoded = new URLSearchParams();
    urlencoded.append("username", getUsernameLogin);
    urlencoded.append("password", getPasswordLogin);
    urlencoded.append("client_id", "userHandling");
    urlencoded.append("client_secret", "fQq9c5FSlngbc6bxqv3m5dSyPzXruj8L");
    urlencoded.append("grant_type", "password");

    var requestOptions = {
      method: 'POST',
      headers: myHeaders,
      body: urlencoded,
      redirect: 'follow'
    };

    const response = await fetch("http://localhost:8080/realms/eshop/protocol/openid-connect/token", requestOptions)
    if(response.ok){
      const login = await response.json()
      const token = login.access_token
      
      //store in localstorage username, email, role (customer, seller) and refresh_token
      const decodeToken = await decodeJwt(token)
      localStorage.setItem("username", decodeToken.preferred_username)
      localStorage.setItem("email", decodeToken.email)
      localStorage.setItem("authToken", decodeToken.sub);
      console.log(decodeToken);


        setTimeout(() => {
            window.location.href = "http://localhost:8000/welcome.html";
        }, 2000);
    }else{
      const err = await response.json()
      console.log(err) 
    }

  } catch (error) {
    console.log(error)
  }
  return false
}

async function Logout(e) {
    e.preventDefault();

    try{
        // Get admin access token
        const adminAccessTokenResponse = await fetch("http://localhost:8080/realms/master/protocol/openid-connect/token", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
            'grant_type': 'client_credentials',
            'client_id': 'admin-cli',
            'client_secret': 'fQq9c5FSlngbc6bxqv3m5dSyPzXruj8L',
          }),
        });

        if (!adminAccessTokenResponse.ok) {
          const err = await adminAccessTokenResponse.json();
          console.log(err);
          return;
        }

        const adminAccessToken = await adminAccessTokenResponse.json();
        const token = adminAccessToken.access_token;


        //Logout user
        const authToken = localStorage.getItem("authToken");
        const logoutResponse = await fetch(`http://localhost:8080/admin/realms/users/${authToken}/logout`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token,
          },
        });

        if (logoutResponse.ok) {
          alert('User logout successful');
          setTimeout(() => {
            window.location.href = "http://localhost:8000/index.html";
          }, 2000);
        } else {
          const err = await logoutResponse.json();
          console.log(err);
        }

    }catch(error) {
        console.log(error);
    }

     


    // Clear the auth token from local storage
    localStorage.clear()
    window.location.href = '/index.html'; // Redirect to login page
}

function authUser(){
    // Retrieve the auth token from local storage
        const authToken = localStorage.getItem("authToken");

        // Check if the auth token exists and is valid
        if (authToken) {
            // Perform actions for authenticated user
            console.log("User is authenticated");
            // You can also decode and inspect the token if needed
        } else {
            // Perform actions for non-authenticated user
            console.log("User is not authenticated");
            window.location = '/index.html';
            // Redirect to login page or show a login button
        }
}