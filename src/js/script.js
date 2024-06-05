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
          throw new Error('Error response: ' + response.status);
        }
        return response.json();
      })
      .then(data => {
        // console.log(data["hasRow"]);
        if (data["hasRow"]){
          // console.log(data["key"]);
          localStorage.setItem('token', data["key"]);
        } else {
          console.log(data);
        }
        // alert(data);
        // Handle successful response
      })

      // .then(response => response.json())
      // .then(data => {
      //   if (!data.ok) {
      //     // Handle error response
      //     console.error('Error:', data);
      //   } else {
      //     // Handle successful response
      //     console.log(data);
      //     // alert(data);
      //   }
      // })
      
      .catch(error => {
        console.error('Catched Error:', error);
        // Handle errors
      });
}