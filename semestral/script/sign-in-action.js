import {addListenerToDocument, sendRequest} from "/script/AJAX.js";

function loginOperation() {
    const formData = new FormData(document.getElementById('sign-in-form'));
    sendRequest(formData, 'POST', '../function/sign-in-action.php', responseFunction)
}

function responseFunction(inputResponse) {
    if (inputResponse.status === 200) {
        const response = inputResponse.responseText.trim();
        if (response === 'HELLO') {
            alert("Welcome to the site!");
            window.location = '/';
        } else {
            alert(response);
        }
    }
}

addListenerToDocument(document, 'sign-in-form', loginOperation);