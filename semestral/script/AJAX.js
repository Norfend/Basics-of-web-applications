export function sendRequest(dataForSending, requestType, requestAddress, inputFunction) {
    const xhr = new XMLHttpRequest();
    xhr.open(requestType, requestAddress, true);
    xhr.onload = function () {
        inputFunction(xhr);
    };
    xhr.send(dataForSending);
}

export function addListenerToDocument(inputDocument, inputElementName, inputFunction) {
    inputDocument.getElementById(inputElementName).addEventListener('submit', function (event) {
        event.preventDefault();
        inputFunction();
    });
    inputDocument.addEventListener('DOMContentLoaded', () => {
        const form = inputDocument.getElementById(inputElementName);
        if (form) {
            form.noValidate = true;
        }
    });
}