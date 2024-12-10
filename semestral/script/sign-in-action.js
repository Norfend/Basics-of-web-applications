function loginOperation() {
    const signInForm = document.getElementById('sign-in-form');
    const formData = new FormData(signInForm);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../function/sign-in-action.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = xhr.responseText.trim();
            if (response === 'HELLO') {
                alert("Welcome to the site!");
                window.location = '/';
            } else {
                alert(response);
            }
        }
    };
    xhr.send(formData);
}

document.getElementById('sign-in-form').addEventListener('submit', function (event) {
    event.preventDefault();
    loginOperation();
});
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('sign-in-form');
    if (form) {
        form.noValidate = true;
    }
});