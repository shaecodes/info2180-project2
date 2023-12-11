document.addEventListener('DOMContentLoaded',function(create){
    var dropdown = document.getElementById('text');

 
    fetch('../php/login.php')
    .then(response => JSON.parse(response.json()))
    .then(data => {
        dropdown.innerHTML = data;
    })
})