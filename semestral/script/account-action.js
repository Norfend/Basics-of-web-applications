/**
 * Script for handling recipe edit and delete actions.
 *
 * This script listens for 'click' events on edit and delete buttons associated with recipes.
 * When a user clicks on the edit button, they are redirected to the recipe edit page.
 * When the delete button is clicked, a request is sent to delete the recipe and update the page accordingly.
 *
 * @module recipeActions
 */

document.addEventListener('DOMContentLoaded', function() {
    const editRecipeButtons = document.querySelectorAll('.recipe-edit-button');
    const deleteRecipeButtons = document.querySelectorAll('.recipe-delete-button');
    const editAccountButtons = document.querySelectorAll('.account-edit-button');
    const deleteAccountButtons = document.querySelectorAll('.account-delete-button');
    const showRecipesButton = document.getElementById('show-recipes');
    const showAccountsButton = document.getElementById('show-accounts');
    const recipesSection = document.getElementById('recipes-section');
    const accountsSection = document.getElementById('accounts-section');

    /**
     * Event listener for recipe edit buttons.
     * Redirects the user to the recipe edit page.
     *
     * Loops through each edit button, and when clicked, it retrieves the recipe ID
     * and redirects the user to the recipe edit page.
     */
    editRecipeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const recipeId = button.getAttribute('data-id');
            window.location.href = `page/recipe-view.php?id=${recipeId}&edit=true`;
        });
    });

    /**
     * Event listener for recipe delete buttons.
     * Sends an AJAX request to delete the recipe.
     *
     * Loops through each delete button, and when clicked, it sends a DELETE request
     * to the server with the recipe ID and the username of the user requesting the deletion.
     * On success, the recipe is removed from the page.
     */
    deleteRecipeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const recipeId = button.getAttribute('data-id');
            const jsonObject = {};
            jsonObject['username'] = document.getElementById('username').innerText;
            jsonObject['recipe_id'] = recipeId;

            const xhr = new XMLHttpRequest();
            xhr.open('DELETE', 'function/recipe-action.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = xhr.responseText.trim();
                    if (response === 'Success') {
                        alert('Recipe was successfully deleted');
                        document.querySelector(`.account-recipe-item[data-id="${recipeId}"]`).remove();
                    } else {
                        alert(response);
                    }
                }
            };
            xhr.send(JSON.stringify(jsonObject));
        });
    });

    /**
     * Event listener for account edit buttons.
     * Redirects the user to the account edit page.
     *
     * Loops through each edit button, and when clicked, it retrieves the account ID
     * and redirects the user to the account edit page.
     */
/*    editAccountButtons.forEach(button => {
        button.addEventListener('click', function() {
            const recipeId = button.getAttribute('data-id');
            window.location.href = `page/recipe-view.php?id=${recipeId}&edit=true`;
        });
    });*/

    /**
     * Event listener for account delete buttons.
     * Sends an AJAX request to delete the account.
     *
     * Loops through each delete button, and when clicked, it sends a DELETE request
     * to the server with the account ID and the username of the user requesting the deletion.
     * On success, the account is removed from the page.
     */
    deleteAccountButtons.forEach(button => {
        button.addEventListener('click', function() {
            const user_id = button.getAttribute('data-id');
            const jsonObject = {};
            jsonObject['username'] = document.getElementById('username').innerText;
            jsonObject['user_id'] = user_id;

            const xhr = new XMLHttpRequest();
            xhr.open('DELETE', 'function/sign-up-action.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = xhr.responseText.trim();
                    if (response === 'Success') {
                        alert('Account was successfully deleted');
                        document.querySelector(`.account-recipe-item[data-id="${user_id}"]`).remove();
                    } else {
                        alert(response);
                    }
                }
            };
            xhr.send(JSON.stringify(jsonObject));
        });
    });

    function toggleView(view) {
        if (view === 'recipes') {
            if (recipesSection != null)recipesSection.style.display = 'block';
            if (accountsSection != null) accountsSection.style.display = 'none';
            if (showRecipesButton != null) showRecipesButton.disabled = true;
            if (showAccountsButton != null) showAccountsButton.disabled = false;
        } else if (view === 'accounts') {
            if (recipesSection != null) recipesSection.style.display = 'none';
            if (accountsSection != null) accountsSection.style.display = 'block';
            if (showRecipesButton != null) showRecipesButton.disabled = false;
            if (showAccountsButton != null) showAccountsButton.disabled = true;
        }
    }

    if (showRecipesButton != null) {
        showRecipesButton.addEventListener('click', function() {
            toggleView('recipes');
        });
    }

    if (showAccountsButton != null) {
        showAccountsButton.addEventListener('click', function() {
            toggleView('accounts');
        });
    }

    toggleView('recipes');
});