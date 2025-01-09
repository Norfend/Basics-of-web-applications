import {addListenerToDocument, sendRequest, setOnChange, validate} from "/script/functions.js";

setup();

function recipeValidation() {
    const formData = new FormData(document.getElementById('recipe-form'));
    if (formValidation(document)) {
        sendRequest(formData, 'POST', '../function/recipe-action.php',
            "Recipe was successfully created");
    }
}

function formValidation(form) {
    const recipeNameField = form.getElementById('recipe-name');
    const descriptionField = form.getElementById('description');
    const howtoField = form.getElementById('howto');
    const ingredientsField = form.getElementById('ingredients');
    const errorField = form.getElementById('error');
    let result = true;

    errorField.innerHTML = '';
    validate(recipeNameField, '^[a-zA-Z0-9\\s]{3,255}$', errorField,
        '<div class="error">Recipe name must be at least 3 characters</div>');
    validate(descriptionField, '^[a-zA-Z0-9\\s_!.,():;?-]{20,5000}$', errorField,
        '<div class="error">Description must be at least 20 characters</div>');
    validate(howtoField, '^[a-zA-Z0-9\\s_!.,():;?-]{20,255}$', errorField,
        '<div class="error">How to must be at least 20 characters</div>');
    validate(ingredientsField, '^[a-zA-Z0-9\\s_!.,():;?-]{20,255}$', errorField,
        '<div class="error">Ingredients must be at least 20 characters</div>');

    if (errorField.innerHTML.length > 0) {
        result = false;
    }
    else console.log(errorField.innerHTML);
    return result;
}

function setup() {
    addListenerToDocument(document, 'recipe-form', recipeValidation);
    setOnChange(document.getElementById('recipe-name'));
    setOnChange(document.getElementById('description'));
    setOnChange(document.getElementById('howto'));
    setOnChange(document.getElementById('ingredients'));
}