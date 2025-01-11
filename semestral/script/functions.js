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

export function addListenerToDocument(inputDocument, inputElementName, inputFunction) {
    inputDocument.getElementById(inputElementName).addEventListener('submit', function (event) {
        event.preventDefault();
        inputFunction();
    });
}

export function setOnChange(element) {
    element.onchange = function() {
        element.classList.remove('invalid');
    }
}

export function validate(inputElement, matcher, errorElement, errorMessage) {
    if (!inputElement.value.match(matcher)) {
        inputElement.classList.add('invalid');
        errorElement.innerHTML += errorMessage;
    }
}