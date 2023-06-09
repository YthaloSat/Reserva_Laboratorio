function toggleTheme() {
    var button = document.getElementById('bd-theme');
    var icon = button.querySelector('svg');
    var text = document.getElementById('bd-theme-text');

    if (document.documentElement.getAttribute('data-bs-theme') === 'dark') {
        document.querySelector('html').setAttribute('data-bs-theme', 'light');
        icon.innerHTML = '<use href="#sun-fill"></use>';
        button.classList.remove('btn-bd-primary');
        button.classList.add('btn-bd-dark');
        icon.classList.remove('theme-icon-active');
        icon.classList.add('theme-icon-inactive');
        text.innerHTML = 'Toggle theme to dark';
        setTheme('light');
    } else {
        document.querySelector('html').setAttribute('data-bs-theme', 'dark');
        icon.innerHTML = '<use href="#moon-stars-fill"></use>';
        button.classList.remove('btn-bd-dark');
        button.classList.add('btn-bd-primary');
        icon.classList.remove('theme-icon-inactive');
        icon.classList.add('theme-icon-active');
        text.innerHTML = 'Toggle theme to light';
        setTheme('dark');
    }
}

function toggleThemeLogin() {
    var button = document.getElementById('bd-theme');
    var icon = button.querySelector('svg');
    var text = document.getElementById('bd-theme-text');

    if (document.documentElement.getAttribute('data-bs-theme') === 'dark') {
        document.querySelector('html').setAttribute('data-bs-theme', 'light');
        icon.innerHTML = '<use href="#sun-fill"></use>';
        button.classList.remove('btn-bd-primary');
        button.classList.add('btn-bd-dark');
        icon.classList.remove('theme-icon-active');
        icon.classList.add('theme-icon-inactive');
        text.innerHTML = 'Toggle theme to dark';
    } else {
        document.querySelector('html').setAttribute('data-bs-theme', 'dark');
        icon.innerHTML = '<use href="#moon-stars-fill"></use>';
        button.classList.remove('btn-bd-dark');
        button.classList.add('btn-bd-primary');
        icon.classList.remove('theme-icon-inactive');
        icon.classList.add('theme-icon-active');
        text.innerHTML = 'Toggle theme to light';
    }
}

function setTheme(theme) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'setTheme.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('theme=' + theme);
}

function hideErrorMessage() {
    var errorMessage = document.getElementById('error-message');
    if (errorMessage) {
        errorMessage.style.display = 'none';
    }
}

function hideMessage() {
    var Message = document.getElementById('message');
    if (Message) {
        Message.style.display = 'none';
    }
}

function hideSuccessMessage() {
    var successMessage = document.getElementById('success-message');
    if (successMessage) {
        successMessage.style.display = 'none';
    }
}

setTimeout(hideErrorMessage, 3000);
setTimeout(hideSuccessMessage, 3000);
setTimeout(hideMessage, 3000);

$(document).ready(function() {
    $('input[name="cpf"]').mask('000.000.000-00', {reverse: true});
  
    $('input[name="email"]').on('input', function() {
      var email = $(this).val();
      var pattern = /^[a-zA-Z0-9._%+-]+@+[a-zA-Z0-9._%+-]+.+[a-zA-Z0-9._%+-]$/i;
  
      if (pattern.test(email)) {
        $(this).removeClass('is-invalid');
      } else {
        $(this).addClass('is-invalid');
      }
    });
});
