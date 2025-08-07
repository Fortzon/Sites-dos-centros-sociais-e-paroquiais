document.getElementById('Check').addEventListener('change', function () {
    const passwordInput = document.getElementById('PasswordTB');
    passwordInput.type = this.checked ? 'text' : 'password';
});