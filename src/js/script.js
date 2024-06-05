document.addEventListener('DOMContentLoaded', function() {

  const form = document.getElementById('form');

  form.addEventListener('submit', function(event) {

      event.preventDefault(); // Prevent the default form submit action

      let formData = new FormData(form);

      let data = { username: formData.get("username"), password: formData.get("password") };

      loginUser(data);
    
      // location.href = "welcome.html";

  });

});

function loginUser(formData){
  fetch('http://localhost/jwt-login/src/api/user', {
        method: 'POST',
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData)
      })
      
      .then(response => {
        if (!response.ok) {
          return response.json();
        }
        return response.json();
      })
      
      .then(data => {
        console.log(data);
        // alert(data);
        // Handle successful response
      })
      
      .catch(error => {
        console.error('Error:', error);
        // Handle errors
      });
}