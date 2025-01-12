import {addListenerToDocument, sendRequest, setOnChange, validate} from "./functions";
/**
 * Script for setting up form validation and AJAX request submission for recipe creation.
 *
 * This script validates the recipe creation form, sends the form data via an AJAX request to the server,
 * and ensures proper user input for recipe fields.
 *
 * @module recipeForm
 */

setup();

/**
 * Validates the recipe form and sends an AJAX request to the server if validation passes.
 *
 * This function collects form data, validates the fields using `formValidation()`, and sends the data
 * to the server via the `sendRequest()` function if the validation is successful.
 *
 * @returns {void}
 */
function recipeValidation() {
    const formData = new FormData(document.getElementById('recipe-form'));
    const urlParams = new URLSearchParams(window.location.search);
    if (formValidation(document)) {
        if (! urlParams.has('edit') && urlParams.get('edit') === 'true') {
            sendRequest(formData, 'POST', 'function/recipe-action.php',
                "Recipe was successfully created");
        }
        else {
            const jsonObject = {};
            jsonObject['recipe_id'] = urlParams.get('id');
            formData.forEach((value, key) => {
                if (jsonObject[key]) {
                    jsonObject[key] = [].concat(jsonObject[key], value);
                } else {
                    jsonObject[key] = value;
                }
            });
            sendRequest(JSON.stringify(jsonObject), 'PUT', 'function/recipe-action.php',
                "Recipe was successfully updated");
        }
    }
}

/**
 * Validates the individual fields in the recipe form.
 *
 * This function validates the `recipe-name`, `description`, `howto`, and `ingredients` fields
 * using the `validate()` function. If any field is invalid, an error message is added to the error
 * section of the form.
 *
 * @param {Document} form - The form element to validate.
 * @returns {boolean} - Returns `true` if the form is valid, otherwise `false`.
 */
function formValidation(form) {
    const recipeNameField = form.getElementById('recipe_name');
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
    validate(howtoField, '^[a-zA-Z0-9\\s_!.,():;?-]{20,5000}$', errorField,
        '<div class="error">How to must be at least 20 characters</div>');
    validate(ingredientsField, '^[a-zA-Z0-9\\s_!.,():;?-]{20,5000}$', errorField,
        '<div class="error">Ingredients must be at least 20 characters</div>');

    if (errorField.innerHTML.length > 0) {
        result = false;
    }
    return result;
}

/**
 * Initializes the form functionality by adding event listeners for validation and input changes.
 *
 * This function adds an event listener for form submission, triggers the validation on submit,
 * and sets up onChange listeners to remove the 'invalid' class on field change.
 *
 * @returns {void}
 */
function setup() {
    addListenerToDocument(document, 'recipe-form', recipeValidation);
    setOnChange(document.getElementById('recipe_name'));
    setOnChange(document.getElementById('description'));
    setOnChange(document.getElementById('howto'));
    setOnChange(document.getElementById('ingredients'));
}