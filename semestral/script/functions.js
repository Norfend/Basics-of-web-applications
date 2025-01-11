/**
 * Utility functions for sending AJAX requests, adding event listeners, and performing validation.
 *
 * @module utils
 */

/**
 * Sends an AJAX request to the specified server address.
 *
 * This function uses the XMLHttpRequest to send data to the server and handles the response.
 * If the server responds with 'Success', it shows a success message and redirects the user.
 *
 * @param dataForSending - The data to be sent in the request body.
 * @param {string} requestType - The HTTP request method (e.g., 'GET', 'POST', 'DELETE').
 * @param {string} requestAddress - The server endpoint to send the request to.
 * @param {string} inputMessage - The message to display upon a successful response.
 */
export function sendRequest(dataForSending, requestType, requestAddress, inputMessage) {
    const xhr = new XMLHttpRequest();
    xhr.open(requestType, requestAddress, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = xhr.responseText.trim();
            if (response === 'Success') {
                alert(inputMessage);
                window.location = 'index.php';
            } else {
                alert(response);
            }
        }
    };
    xhr.send(dataForSending);
}

/**
 * Adds an event listener to a form's submit event.
 *
 * This function prevents the default form submission and executes the specified function when the form is submitted.
 *
 * @param {Document} inputDocument - The document object containing the form.
 * @param {string} inputElementName - The ID of the form element to attach the listener to.
 * @param {Function} inputFunction - The function to execute upon form submission.
 */
export function addListenerToDocument(inputDocument, inputElementName, inputFunction) {
    inputDocument.getElementById(inputElementName).addEventListener('submit', function (event) {
        event.preventDefault();
        inputFunction();
    });
}

/**
 * Sets an onChange listener to remove the 'invalid' class when an input changes.
 *
 * This function is typically used for input fields to remove the 'invalid' class when the user corrects the input.
 *
 * @param {HTMLElement} element - The input element to add the onChange listener to.
 */
export function setOnChange(element) {
    element.onchange = function() {
        element.classList.remove('invalid');
    }
}

/**
 * Validates the input element against a regular expression and displays an error message if invalid.
 *
 * This function checks if the input value matches the provided regular expression. If not, it adds the 'invalid' class
 * to the input element and appends the error message to the specified error element.
 *
 * @param {HTMLElement} inputElement - The input element to validate.
 * @param {String} matcher - The regular expression to match the input value against.
 * @param {HTMLElement} errorElement - The element where the error message will be displayed.
 * @param {string} errorMessage - The error message to display if validation fails.
 */
export function validate(inputElement, matcher, errorElement, errorMessage) {
    if (!inputElement.value.match(matcher)) {
        inputElement.classList.add('invalid');
        errorElement.innerHTML += errorMessage;
    }
}