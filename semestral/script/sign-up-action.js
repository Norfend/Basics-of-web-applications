import {addListenerToDocument, sendRequest, setOnChange, validate} from "/script/functions.js";

setup();

function signupOperation() {
    const formData = new FormData(document.getElementById('signup-form'));
    if (formValidation(document)) {
        sendRequest(formData, 'POST', '../function/sign-up-action.php',
            "Account was successfully created");
    }
}

function formValidation(form) {
    const firstNameField = form.getElementById('first_name');
    const lastNameField = form.getElementById('last_name');
    const usernameField = form.getElementById('username');
    const emailField = form.getElementById('email');
    const passwordField = form.getElementById('password');
    const confirmPasswordField = form.getElementById('confirm_password');
    const errorField = form.getElementById('error');
    let result = true;

    validate(firstNameField, '^[a-zA-Z0-9_]{6,255}$', errorField,
        '<div class="error">First name must be at least 2 characters</div>');
    validate(lastNameField, '^[a-zA-Z0-9_]{6,255}$', errorField,
        '<div class="error">Last name must be at least 2 characters</div>');
    validate(usernameField, '^[a-zA-Z0-9_]{6,255}$', errorField,
        '<div class="error">Username must be at least 6 characters long and contain only letters and numbers</div>');
    validate(emailField, '^[\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$', errorField, '<div class="error">Email is invalid</div>');
    if (passwordField.value !== confirmPasswordField.value || confirmPasswordField.value === '') {
        confirmPasswordField.classList.add('invalid');
        errorField.innerHTML += '<div class="error">Passwords don\'t match</div>';
    }
    validate(passwordField, '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[A-Za-z\\d@$!%*?&]{8,}$', errorField,
        '<div class="error">Password must be at least 8 characters long, contain at least one lowercase letter, one uppercase letter, and one number</div>');

    if (errorField.innerHTML.length > 0) {
        result = false;
    }
    else console.log(errorField.innerHTML);
    return result;
}

function setup() {
    addListenerToDocument(document, 'signup-form', signupOperation);
    setOnChange(document.getElementById('first_name'));
    setOnChange(document.getElementById('last_name'));
    setOnChange(document.getElementById('username'));
    setOnChange(document.getElementById('email'));
    setOnChange(document.getElementById('password'));
    setOnChange(document.getElementById('confirm_password'));
}