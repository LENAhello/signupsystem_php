document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('change', function () {
        console.log('checked');
        password.type = this.checked ? 'text' : 'password';
    });
});