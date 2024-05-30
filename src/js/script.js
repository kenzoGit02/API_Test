document.addEventListener('DOMContentLoaded', function() {

const form = document.getElementById('form')

form.addEventListener('submit', function(event) {

    event.preventDefault(); // Prevent the default form submit action

    const formData = new FormData(form)
    // alert(`username: ${formData.get("username")}`)
    // alert(`pw: ${formData.get("password")}`)

    fetch('http://localhost/apitest/test/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          name: 'Product 1'
        })
      })
      .then(response => {
        if (!response.ok) {
          return response.json()
        }
        return response.json()
      })
      .then(data => {
        console.log(data);
        // Handle successful response
      })
      .catch(error => {
        console.error('Error:', error);
        // Handle errors
      });
    });
});
