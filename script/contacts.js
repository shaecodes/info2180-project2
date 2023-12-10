document.addEventListener('DOMContentLoaded',function(create){
    var dropdown = document.getElementById('assign_user');

    var div = document.getElementByClassName('contact');
                    var popup = document.createElement('div');
                    popup.setAttribute('class', 'popup');
                    var para = document.createElement('p');
                    p.innerHTML = 'Login Successfully';
                    popup.appendChild(para);
                    div.appendChild(popup);
    fetch('../php/contacts.php')
    .then(response => response.text())
    .then(data => {
        dropdown.innerHTML = data;
    })
})