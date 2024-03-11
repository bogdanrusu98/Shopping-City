document.getElementById('submitButtonNews').addEventListener('click', function(event) {
    event.preventDefault(); // Previne comportamentul implicit de submit al formularului

    var name = document.getElementById('name').value;
    var email = document.getElementById('exampleInputEmail1').value;

    // Exemplu de validare simplă pentru nume
    if (name.length < 3) {
        document.getElementById('nameError').style.display = 'block';
        return; // Ieși din funcție pentru a nu trimite datele
    } else {
        document.getElementById('nameError').style.display = 'none';
    }

    // Trimite datele către server utilizând AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/register_newsletter.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            document.getElementById('message').innerText = response.message;
            if (response.status === 'success') {
                document.getElementById('message');
            } else {
                document.getElementById('message').style.color = 'red';
            }
        }
    };
    xhr.send('name=' + encodeURIComponent(name) + '&email=' + encodeURIComponent(email));
});
