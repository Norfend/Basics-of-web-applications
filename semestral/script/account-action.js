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
    const editButtons = document.querySelectorAll('.recipe-edit-button');
    const deleteButtons = document.querySelectorAll('.recipe-delete-button');
    /**
     * Event listener for recipe edit buttons.
     * Redirects the user to the recipe edit page.
     *
     * Loops through each edit button, and when clicked, it retrieves the recipe ID
     * and redirects the user to the recipe edit page.
     */
    editButtons.forEach(button => {
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
    deleteButtons.forEach(button => {
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
});
