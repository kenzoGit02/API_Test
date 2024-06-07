document.addEventListener('DOMContentLoaded', function() {

    let logoutButton = this.getElementById("logout-button");

    logoutButton.addEventListener('click', function(e){
        logout();
    });

});

function checkAuthentication(){
    if(localStorage.getItem('token')){

        console.log("may token");

        try{
            let decodedToken = decodeToken(localStorage.getItem('token'));

            console.log('Decoded payload:', decodedToken);

            const currentTime = Math.floor(Date.now() / 1000);

            console.log(currentTime);

            console.log(decodedToken.exp < currentTime);
            //if token expired
            if (decodedToken.exp < currentTime){
                throw new Error('token expired');
            }

        }catch(error){

            console.error('Error decoding token:', error.message);
            alert("may mali sa token, balik sa login");
            location.href = "index.html";
        }

    } else {

        console.log("wala token, balik sa login");
        location.href = "index.html";

    }
}
function decodeToken(token){

    let splitToken = token.split('.');

    if (splitToken.length !== 3){
        throw new Error('invalid token');
    }

    console.log("valid token");

    const payload = JSON.parse(atob(splitToken[1]));

    return payload;
}
function logout(){
    localStorage.removeItem('token');
    alert("logged out");
    location.href = "index.html";
}
checkAuthentication();
