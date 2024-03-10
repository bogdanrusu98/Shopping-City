
        // Funcție pentru validarea formularului înainte de trimitere
        function validateForm() {
            var username = document.getElementById('username').value;
            var firstName = document.getElementById('firstName').value;
            var lastName = document.getElementById('lastName').value;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

            if (username.length < 6 || firstName.length < 3 || lastName.length < 3 || password.length < 6 || password !== confirmPassword) {
                // Afișați mesajele de eroare corespunzătoare
                document.getElementById('usernameError').style.display = (username.length < 6) ? 'inline' : 'none';
                document.getElementById('firstNameError').style.display = (firstName.length < 3) ? 'inline' : 'none';
                document.getElementById('lastNameError').style.display = (lastName.length < 3) ? 'inline' : 'none';
                document.getElementById('passwordError').style.display = (password.length < 6) ? 'inline' : 'none';
                document.getElementById('confirmPasswordError').style.display = (password !== confirmPassword) ? 'inline' : 'none';
                return false;
            }
            return true;
        }

        // Funcții pentru validarea câmpurilor în timpul schimbării valorilor
        function validateUsername() {
            var username = document.getElementById('username').value;
            document.getElementById('usernameError').style.display = (username.length < 6) ? 'inline' : 'none';
        }

        function validateFirstName() {
            var firstName = document.getElementById('firstName').value;
            document.getElementById('firstNameError').style.display = (firstName.length < 3) ? 'inline' : 'none';
        }

        function validateLastName() {
            var lastName = document.getElementById('lastName').value;
            document.getElementById('lastNameError').style.display = (lastName.length < 3) ? 'inline' : 'none';
        }

        function validatePassword() {
            var password = document.getElementById('password').value;
            document.getElementById('passwordError').style.display = (password.length < 6) ? 'inline' : 'none';
        }

        function validateConfirmPassword() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            document.getElementById('confirmPasswordError').style.display = (password !== confirmPassword) ? 'inline' : 'none';
        }
