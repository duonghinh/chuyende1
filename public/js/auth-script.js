document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.querySelector('.wrapper');
    const loginLink = document.querySelector('.login-link');
    const registerLink = document.querySelector('.register-link');

    const headerLoginBtn = document.getElementById('header-login-btn');
    const headerRegisterBtn = document.getElementById('header-register-btn');
    if (!wrapper) return;
    function switchToRegister(e) {
        e.preventDefault();
        wrapper.classList.add('active');
        window.history.pushState({path: 'register'}, '', '/dang-ky');
    }

    function switchToLogin(e) {
        e.preventDefault();
        wrapper.classList.remove('active');
        window.history.pushState({path: 'login'}, '', '/dang-nhap');
    }

    if (registerLink) registerLink.addEventListener('click', switchToRegister);
    if (loginLink) loginLink.addEventListener('click', switchToLogin);

    if (headerRegisterBtn) {
        headerRegisterBtn.addEventListener('click', function(e) {
            switchToRegister(e);
        });
    }

    if (headerLoginBtn) {
        headerLoginBtn.addEventListener('click', function(e) {
            switchToLogin(e);
        });
    }
});