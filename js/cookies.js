window.acceptCookies = function() {
    setCookie("cookies_accepted", "true", 365);
    document.getElementById("cookie-banner").style.display = "none";
};

document.addEventListener("DOMContentLoaded", function() {
    var cookieBanner = document.getElementById('cookie-banner');
    var acceptCookiesBtn = document.getElementById('accept-cookies-btn');

    // Verifică dacă utilizatorul a acceptat deja cookie-urile
    if (!getCookie('cookies_accepted')) {
        cookieBanner.style.display = 'block';
    } else {
        cookieBanner.style.display = 'none'; // Ascunde banner-ul dacă cookie-urile au fost acceptate
    }

    acceptCookiesBtn.addEventListener('click', function() {
        setCookie('cookies_accepted', 'true', 365); // Stabilește cookie-ul pentru 365 de zile
        cookieBanner.style.display = 'none'; // Ascunde banner-ul după ce sunt acceptate cookie-urile
    });

    // Funcția pentru setarea cookie-urilor
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // Funcția pentru a obține valoarea unui cookie
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }
});
