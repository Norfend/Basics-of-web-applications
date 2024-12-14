import {addListenerToDocument, sendRequest, setOnChange, validate} from "/script/functions.js";

setup();

function loginOperation() {
    const formData = new FormData(document.getElementById('sign-in-form'));
    if (formValidation(document.getElementById('sign-in-form'))) {
        sendRequest(formData, 'POST', '../function/sign-in-action.php',
            'Welcome to the site!')
    }
}

function formValidation(form) {
    const usernameField = form.getElementById('username');
    const passwordField = form.getElementById('password');
    const errorField = form.getElementById('error');
    let result = true;

    errorField.innerHTML = '';

    validate(usernameField, '^[a-zA-Z0-9_]{6,255}$', errorField,
        '<div class="error">Username must be at least 6 characters long and contain only letters and numbers</div>');
    validate(passwordField, '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[A-Za-z\\d@$!%*?&]{8,}$', errorField,
        '<div class="error">Password must be at least 8 characters long, contain at least one lowercase letter, one uppercase letter, and one number</div>');

    if (errorField.innerHTML.length > 0) {
        result = false;
    }
    return result;
}

function setup() {
    addListenerToDocument(document, 'sign-in-form', loginOperation);
    setOnChange(document.getElementById('username'));
    setOnChange(document.getElementById('password'));
}