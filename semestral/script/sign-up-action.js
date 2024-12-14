import {addListenerToDocument, sendRequest} from "/script/AJAX.js";

function signupOperation() {
    const formData = new FormData(document.getElementById('signup-form'));
    sendRequest(formData, 'POST', '../function/sign-up-action.php', responseFunction);
}

function responseFunction(inputResponse) {
    if (inputResponse.status === 200) {
        const response = inputResponse.responseText.trim();
        if (response === 'Success') {
            alert("Account was successfully created");
            window.location = '/';
        } else {
            alert(response);
        }
    }
}

addListenerToDocument(document, 'signup-form', signupOperation);