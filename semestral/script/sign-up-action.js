function validateAccountData() {
    const signupForm = document.getElementById('signup-form');
    const formData = new FormData(signupForm);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../function/sign-up-action.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = xhr.responseText.trim();
            if (response === 'Success') {
                alert("Account was successfully created");
                window.location = '/';
            } else {
                alert(response);
            }
        }
    };
    xhr.send(formData);
}

document.getElementById('signup-form').addEventListener('submit', function (event) {
    event.preventDefault();
    validateAccountData();
});
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('signup-form');
    if (form) {
        form.noValidate = true;
    }
});