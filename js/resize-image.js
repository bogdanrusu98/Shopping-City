// Obținem elementele modalelor
var resizeModal = document.getElementById('resizeModal');
var openModalButton = document.getElementById('openModalButton');
var closeButton = document.getElementsByClassName('close')[0];

// Ascultăm evenimentul de click pe butonul pentru deschiderea modalului
openModalButton.addEventListener('click', function() {
    resizeModal.style.display = "block";
});

// Ascultăm evenimentul de click pe butonul pentru închiderea modalului
closeButton.addEventListener('click', function() {
    resizeModal.style.display = "none";
});

// Ascultăm evenimentul de click pe fereastra pentru închiderea modalului
window.addEventListener('click', function(event) {
    if (event.target == resizeModal) {
        resizeModal.style.display = "none";
    }
});

// Obținem elementele necesare
var saveResizedImage = document.getElementById('saveResizedImage');
var resizableImage = document.getElementById('resizableImage');

// Ascultăm evenimentul de click pe butonul de salvare
saveResizedImage.addEventListener('click', function() {
    // Creăm un obiect FormData pentru a trimite imaginea redimensionată la server
    var formData = new FormData();
    formData.append('resizedImage', resizableImage.src); // Src-ul imaginii redimensionate

    // Trimitem imaginea redimensionată la server folosind AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload-resized-image.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Răspunsul de la server
            var response = xhr.responseText;
            // Poți face alte acțiuni în funcție de răspunsul serverului
            console.log(response);
        } else {
            // Tratați cazul în care există o eroare la trimiterea către server
            console.error('Eroare la trimiterea către server: ' + xhr.status);
        }
    };
    xhr.send(formData); // Trimiterea datelor către server
});
