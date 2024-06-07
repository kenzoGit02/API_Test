document.addEventListener('DOMContentLoaded', function() {
  
  const form = document.getElementById('form');

  form.addEventListener('submit', function(event) {

      event.preventDefault(); // Prevent the default form submit action

      let formData = new FormData(form);

      let data = { username: formData.get("username"), password: formData.get("password") };

      loginUser(data);
    
      

  });

});

function loginUser(formData){
  fetch('http://localhost/jwt-login/src/api/user', {
        method: 'POST',
        // headers: {
        //   "Content-Type": "application/json",
        // },
        body: JSON.stringify(formData)
      })

      .then(response => {
        if (!response.ok) {
          throw new Error('Error response: ' + response.status);
        }
        return response.json();
      })
      .then(data => {
        console.log(data);
        if (data["hasRow"]){
          localStorage.setItem('token', data["key"]);
          alert("key stored");

          location.href = "welcome.html";

        } else {
          console.log(data);
          alert("Wrong Credentials");
        }
      })
      .catch(error => {
        console.error('Catched Error:', error);
      });
}