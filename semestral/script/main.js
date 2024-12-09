let usernameIsAvailable = false;

function checkUsernameAvailability() {
    const signupForm = document.getElementById('signup-form');
    const formData = new FormData(signupForm);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../function/sign-up-action.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = xhr.responseText.trim();
            if (response === 'Success') {
                usernameIsAvailable = true;
            } else {
                alert(response);
            }
        }
    };
    xhr.send(formData);
}

document.getElementById('submit').addEventListener('click', checkUsernameAvailability);
document.getElementById('signup-form').addEventListener('submit', function (event) {
    event.preventDefault();
    if (usernameIsAvailable) {
        window.location = '/';
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('signup-form');
    if (form) {
        form.noValidate = true;
    }
});