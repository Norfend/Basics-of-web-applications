import {addListenerToDocument, sendRequest, setOnChange, validate} from "./functions";
/**
 * Script for handling the login form validation and submission.
 *
 * This script validates the login form, sends the form data via an AJAX request to the server,
 * and ensures the user provides valid credentials (username and password).
 *
 * @module loginForm
 */

setup();

/**
 * Validates the login form and sends an AJAX request to the server if validation passes.
 *
 * This function collects form data, validates the `username` and `password` fields using
 * `formValidation()`, and sends the data to the server via `sendRequest()` if the validation is successful.
 *
 * @returns {void}
 */
function loginOperation() {
    const formData = new FormData(document.getElementById('sign-in-form'));
    if (formValidation(document)) {
        sendRequest(formData, 'POST', 'function/sign-in-action.php',
            'Welcome to the site!');
    }
}

/**
 * Validates the `username` and `password` fields of the login form.
 *
 * This function checks if the `username` meets the criteria (at least 6 characters, only letters and numbers)
 * and if the `password` meets the security requirements (at least 8 characters, containing one lowercase letter,
 * one uppercase letter, and one number). If any field is invalid, an error message is added to the error section.
 *
 * @param {Document} form - The form element to validate.
 * @returns {boolean} - Returns `true` if the form is valid, otherwise `false`.
 */
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

/**
 * Initializes the login form functionality by adding event listeners for validation and input changes.
 *
 * This function adds an event listener for form submission, triggers the validation on submit,
 * and sets up onChange listeners to remove the 'invalid' class on field change.
 *
 * @returns {void}
 */
function setup() {
    addListenerToDocument(document, 'sign-in-form', loginOperation);
    setOnChange(document.getElementById('username'));
    setOnChange(document.getElementById('password'));
}